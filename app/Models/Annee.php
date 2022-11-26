<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class Annee extends Model
{
    use HasFactory;

    public $guarded = [];

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
    public static function encours(): Annee
    {
        return self::where('encours', true)->latest()->first();

    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->nom .= "-" . ($model->nom + 1);
        });
        static::updating(function ($model) {
            try {
                $model->nom .= "-" . ($model->nom + 1);
            } catch (Throwable $th) {
                //throw $th;
            }
        });
    }

    public function getNomEditAttribute(): string
    {
        return explode("-", $this->nom)[0];
    }
}
