<?php

namespace App\Models;

use App\Enums\FraisFrequence;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Perception extends Model
{
    use HasFactory, HasUlids;

    public $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'frequence' => FraisFrequence::class,
    ];

    protected $with = ['frais'];

    // boot

    public static function dataOfLast($days = 7)
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

    protected static function boot()
    {
        parent::boot();

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
        $count = self::where('annee_id', Annee::id())->whereMonth('created_at', Carbon::now()->month)->count();
        $count = Str::padLeft($count, 4, '0');
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        return $count . $month . $year;
    }


    public function frais()
    {
        return $this->belongsTo(Frais::class);
    }

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
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
