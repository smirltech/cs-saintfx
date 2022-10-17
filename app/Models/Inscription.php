<?php

namespace App\Models;

use App\Enum\AdmissionType;
use App\Enum\InscriptionCategorie;
use App\Enum\InscriptionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Str;

//use Illuminate\Database\Eloquent\SoftDeletes;

class Inscription extends Model
{
    use HasFactory;

    //, SoftDeletes;

    public $guarded = [];

    protected $casts = [
        'type' => AdmissionType::class,
        'status' => InscriptionStatus::class,
        'categorie' => InscriptionCategorie::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (!$model->code) {
                $annee = Annee::encours();
                $count = Inscription::where('annee_id', $annee->id)->count();
                //  $model->code = (int)(explode('-', $annee->nom)[1]) + $count;
                $annee = (explode('-', $annee->nom)[1]);

                // count has to be 4 digits
                $count = str_pad($count, 3, '0', STR_PAD_LEFT);

                $model->code = Str::substr($annee, 2, 4) . $count;
            }
        });
    }


    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }


    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }


    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
