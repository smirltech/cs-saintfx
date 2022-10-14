<?php

namespace App\Models;

use App\Enum\AdmissionType;
use App\Enum\InscriptionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inscription extends Model
{
    use HasFactory, SoftDeletes;

    public $guarded = [];

    protected $casts = [
        'type' => AdmissionType::class,
        'status' => InscriptionStatus::class,
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
                $model->code = (int)(explode('-', $annee->nom)[1]) + $count;
            }
        });
    }


    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }


    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function promotion2()
    {
        return $this->belongsTo(Promotion::class, 'promotion2_id');
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
