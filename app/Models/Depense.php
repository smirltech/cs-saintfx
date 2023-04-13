<?php

namespace App\Models;

use App\Enums\DepenseCategorie;
use App\Enums\DepenseStatus;
use App\Enums\Devise;
use App\Enums\UserRole;
use App\Notifications\DepenseCreated;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Notification;
use SmirlTech\LaravelMedia\Traits\HasMedia;
use Spatie\ModelStatus\Events\StatusUpdated;
use Spatie\ModelStatus\HasStatuses;

class Depense extends Model
{
    use HasFactory, HasStatuses, HasUlids, HasMedia;

    public $guarded = [];
    protected $casts = [
        'categorie' => DepenseCategorie::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'devise' => Devise::class,
    ];

    protected $with = ['user'];

    public static function dataOfLast($days = 7): array
    {
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $lDate = Carbon::now()->subDays($i);
            $data[] = self::whereDate('created_at', '=', $lDate)->sum('montant');
        }
        return $data;
    }

    public static function sommeBetween($annee_id, $ddebut, $dfin)
    {
        $debut = Carbon::parse($ddebut)->startOfDay();
        $fin = Carbon::parse($dfin)->endOfDay();
        return self::where('annee_id', $annee_id)->whereBetween('created_at', [$debut, $fin])->sum('montant');
    }

    public static function sommeDepensesByTypeBetween(int $annee_id, $ddebut, $dfin): array
    {
        $debut = Carbon::parse($ddebut)->startOfDay();
        $fin = Carbon::parse($dfin)->endOfDay();
        $data = [];
        $depTypes = DepenseType::all();
        foreach ($depTypes as $ty) {
            $data[$ty->nom] = self::where('annee_id', $annee_id)->where('depense_type_id', $ty->id)->whereDate('created_at', '>=', $debut)->whereDate('created_at', '<=', $fin)->sum('montant');
        }

        return $data;
    }

    protected static function booted(): void
    {

        self::creating(function (Depense $depense) {
            if (!$depense->annee_id) {
                $depense->annee_id = Annee::id();
            }

            if (!$depense->user_id) {
                $depense->user_id = Auth::id();
            }
        });

        self::created(function (Depense $depense) {
            $depense->setStatus(DepenseStatus::pending->value, "{$depense->user->name} a créé dépense pour {$depense->type->nom} de {$depense->montant} {$depense->devise}");
        });
    }

    public function notifyAll(DepenseCreated $notification, array $roles): void
    {
        $users = User::role($roles)->get();
        $users->push($this->user);
        Notification::send($users, $notification);
    }

    public function getStatusRolesAttribute(): ?array
    {
        return DepenseStatus::tryFrom($this->status)?->roles();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(DepenseType::class, 'depense_type_id');
    }

    public function getDisplayMontantAttribute(): string
    {
        return number_format($this->montant, 0, ',', ' ') . ' ' . $this->devise ?? 'CDF';
    }


    /**
     * @throws Exception
     */
    public function reject(?string $status_note): void
    {
        $status_name = match (Auth::user()?->role?->name) {
            UserRole::promoteur->value => DepenseStatus::rejected_promoteur->value,
            UserRole::coordonnateur->value => DepenseStatus::rejected_coordonnateur->value,
            default => null,
        };
        if ($status_name) {
            $this->forceSetStatus($status_name, $status_note);
        } else {
            throw new Exception('Vous n\'avez pas le droit de rejeter cette dépense');
        }


    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // timeline

    public function forceSetStatus(string $name, ?string $reason = null): self
    {
        $oldStatus = $this->latestStatus();

        $newStatus = $this->statuses()->create([
            'name' => $name,
            'reason' => $reason,
            'user_id' => Auth::id()
        ]);

        event(new StatusUpdated($oldStatus, $newStatus, $this));

        return $this;
    }

    public function isApproved(): bool
    {
        return $this->isApprovedByCoordonnateur() || $this->isApprovedByPromoteur();
    }

    public function isApprovedByCoordonnateur(): bool
    {
        return match ($this->status()?->name) {
                DepenseStatus::approved_coordonnateur->value => true,
                default => false
            } || $this->isApprovedByPromoteur();
    }

    public function isApprovedByPromoteur(): bool
    {
        return match ($this->status()?->name) {
            DepenseStatus::approved_promoteur->value, DepenseStatus::done->value, DepenseStatus::issued->value => true,
            default => false
        };
    }

    public function canBeApprovedByUser(): bool
    {
        return (match ($this->status) {
                    DepenseStatus::approved_coordonnateur, DepenseStatus::rejected_promoteur => true,
                    default => false
                } && Auth::user()?->role?->name === UserRole::promoteur->value) || (match ($this->status) {
                    DepenseStatus::pending, DepenseStatus::rejected_coordonnateur => true,
                    default => false
                } && Auth::user()?->role?->name === UserRole::coordonnateur->value);
    }

    /**
     * @throws Exception
     */
    public function approve(?string $status_note): void
    {
        $status_name = match (Auth::user()?->role?->name) {
            UserRole::promoteur->value => DepenseStatus::approved_promoteur->value,
            UserRole::coordonnateur->value => DepenseStatus::rejected_promoteur->value,
            default => null,
        };

        if ($status_name) {
            $this->setStatus($status_name, $status_note);
        } else {
            throw new Exception('Vous n\'avez pas le droit d\'approuver cette dépense');
        }

    }
}
