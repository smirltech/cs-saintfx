<?php

namespace App\Models;

use App\Enums\FraisFrequence;
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
        'frequence' => FraisFrequence::class,
    ];

    protected $with = ['frais'];

    // boot

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

    public static function scopePaid($query, $paid = true)
    {
        return $query->where('paid', $paid);
    }

    public static function scopeUnpaid($query)
    {
        return $query->where('paid', false);
    }

    protected static function booted(): void
    {

        static::creating(function (Perception $model) {
            $model->reference = self::generateReference();
        });
    }

    /**
     * Create a reference for the perception based on the current month and year and the number of perceptions for the current month
     * Model: {count:4 digits}{month:2 digits}{year:2 digits}
     * Ex : 00010123
     * @return string
     */
    public static function generateReference(): string
    {
        $count = self::whereMonth('created_at', Carbon::now()->month)->count();
        $count = Str::padLeft($count + 1, 4, '0');
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

    public function getBalanceAttribute(): int
    {
        return $this->montant - $this->paid;
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
