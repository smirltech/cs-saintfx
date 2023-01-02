<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class Annee extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $appends = [
        'start_year',
        'end_year',
    ];

    /**
     * Renvoie l'id de l'année scolaire en cours
     * @return int
     */
    public static function id(): int
    {
        return self::encours()->id;
    }


    /**
     * Renvoie l'année scolaire en cours
     * @return Annee
     */
    public static function encours(): self
    {
        return self::where('encours', true)->latest()->first();

    }

    protected static function boot()
    {
        parent::boot();

        /*static::creating(function ($model) {
            $model->nom .= "-" . ($model->nom + 1);
        });
        static::updating(function ($model) {
            try {
                $model->nom .= "-" . ($model->nom + 1);
            } catch (Throwable $th) {
                //throw $th;
            }
        });*/
    }


    /**
     * @deprecated deprecated since version 1.0
     */
    public function getNomAttribute(): string
    {
        return $this->code;
    }

    public function getCodeAttribute(): string
    {
        return $this->start_year . '-'.$this->end_year;
    }

    public function getStartYearAttribute(): string
    {
        return Carbon::parse($this->date_debut)->year;
    }

    public function getEndYearAttribute(): string
    {
        return Carbon::parse($this->date_fin)->year;
    }
}
