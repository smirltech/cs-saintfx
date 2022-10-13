<?php

namespace App\Models;

use App\Enum\AdmissionStatus;
use App\Enum\AdmissionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admission extends Model
{
    use HasFactory, SoftDeletes;

    public $guarded = [];

    protected $casts = [
        'type' => AdmissionType::class,
        'status' => AdmissionStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (!$model->code) {
                $annee = Annee::encours();
                $count = Admission::where('annee_id', $annee->id)->count();
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
