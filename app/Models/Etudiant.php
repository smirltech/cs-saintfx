<?php

namespace App\Models;

use App\Enum\EtatCivil;
use App\Enum\EtudiantSexe;
use App\Enum\EtudiantStep;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etudiant extends Model
{
    use HasFactory, SoftDeletes;

    public $guarded = [];

    protected $casts = [
        'sexe' => EtudiantSexe::class,
        'step' => EtudiantStep::class,
        'etat_civil' => EtatCivil::class,
        'date_naissance' => 'datetime',
    ];

    public function otp()
    {
        return $this->hasOne(Otp::class, 'identifier', 'email');
    }

    /**
     * Get the user that owns the phone.
     */
    public function diplome()
    {
        return $this->hasOne(Diplome::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }

    // full_name
    public function getFullNameAttribute(): string
    {
        return "{$this->nom} {$this->postnom} {$this->prenom}";
    }

}
