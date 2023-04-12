<?php

namespace App\Models;

use App\Enums\DepenseCategorie;
use App\Enums\DepenseStatus;
use App\Enums\Devise;
use App\Notifications\DepenseCreated;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Notification;
use Spatie\ModelStatus\Events\StatusUpdated;
use Spatie\ModelStatus\HasStatuses;

class Depense extends Model
{
    use HasFactory, HasStatuses, HasUlids;

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
        Notification::send($users, $notification);
    }

    public function getStatusRolesAttribute(): ?array
    {
        return DepenseStatus::tryFrom($this->status)?->roles();
    }

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(DepenseType::class, 'depense_type_id');
    }
}
