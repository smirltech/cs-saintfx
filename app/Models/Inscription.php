<?php

namespace App\Models;

use App\Enums\AdmissionType;
use App\Enums\InscriptionCategorie;
use App\Enums\InscriptionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
            if (!$model?->eleve?->matricule) {

                $model->eleve->matricule = Eleve::generateMatricule($model?->classe?->section_id);

                $model->eleve->save();
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

    // scope annee
    public function scopeAnnee($query, $annee_id = null)
    {
        if ($annee_id) {
            return $query->where('annee_id', $annee_id);
        }
        return $query->where('annee_id', Annee::encours()->id);
    }

    // scope eleve
    public function scopeEleve($query, $eleve_id = null)
    {
        if ($eleve_id) {
            return $query->where('eleve_id', $eleve_id);
        }
        return $query;
    }

    // scope classe
    public function scopeClasse($query, $classe_id = null)
    {
        if ($classe_id) {
            return $query->where('classe_id', $classe_id);
        }
        return $query;
    }

    public function getCodeAttribute(): ?string
    {
        return $this?->eleve->matricule;
    }

}
