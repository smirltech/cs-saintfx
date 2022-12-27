<?php

namespace App\Models;

use App\Enums\FraisFrequence;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function frais()
    {
        return $this->belongsTo(Frais::class);
    }

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
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
