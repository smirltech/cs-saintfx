<?php

namespace App\Models;

use App\Enums\FraisType;
use App\Enums\MinervalMonth;
use App\Traits\HasScopeAnnee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Perception extends Model
{
    use HasFactory, HasUlids, HasScopeAnnee;

    public $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $with = ['frais'];

    // booted
    public static function total()
    {
        return self::where('annee_id', Annee::id())->sum('montant');
    }

    protected static function booted(): void
    {
        static::creating(function (Perception $model) {
            $model->reference = self::generateReference();
            $model->user_id = $model->user_id ?? auth()->id();
            $model->annee_id = Annee::id();
        });
    }

    public function getLabelAttribute(): ?string
    {
        if ($this->frais->type == FraisType::MINERVAL) {
          return  $this->frais->nom . ' - ' . MinervalMonth::tryFrom($this->custom_property)?->label();
        }

        return $this->frais->nom;
    }

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

    // eleve through inscription

    public static function scopePaid($query)
    {
        return $query->where('montant', '>', 0);
    }

    public static function scopeUnpaid($query)
    {
        return $query->where('paid', false);
    }


    /**
     * Create a reference for the perception based on the current month and year and the number of perceptions for the current month
     * Model: {count:4 digits}{month:2 digits}{year:2 digits}
     * Ex : 00010123
     */
    public static function generateReference(): string
    {
        $count = self::whereMonth('created_at', Carbon::now()->month)->count();
        $count = Str::padLeft($count + 1, 3, '0');
        $month = Carbon::now()->format('ym');

        return $month . $count;
    }

    public function getEleveAttribute()
    {
        return $this->inscription->eleve;
    }

    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

    public function frais(): BelongsTo
    {
        return $this->belongsTo(Frais::class);
    }

    public function getBalanceAttribute(): float
    {
        // sum of all perceptions for the current year for the inscription and the fraistr
        return $this->inscription->perceptions()->where('frais_id', $this->frais_id)->where('annee_id', Annee::id())->sum('montant');
    }

    public function getNomCompletAttribute(): string
    {
        return $this->getFullNameAttribute();
    }

    public function getFullNameAttribute(): string
    {
        return $this->inscription->fullName;
    }

    public function getClasseAttribute(): string
    {
        return $this->inscription->classe->code;
    }
}
