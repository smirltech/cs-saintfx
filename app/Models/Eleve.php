<?php

namespace App\Models;

use App\Enums\Sexe;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Eleve extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'sexe' => Sexe::class,
        'date_naissance' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }


    public function currentInscription()
    {
        $y = Annee::where('encours', 1)->first();
        return Inscription::where(['eleve_id' => $this->id, 'annee_id' => $y->id])->first();
    }

    // full_name
    public function getFullNameAttribute(): string
    {
        return "{$this->nom} {$this->postnom} {$this->prenom}";
    }

    public function responsable_eleve()
    {
        return $this->hasOne(ResponsableEleve::class);
    }

    public function responsables(): HasManyThrough
    {
        return $this->hasManyThrough(Responsable::class, ResponsableEleve::class, 'eleve_id', 'id', 'id', 'responsable_id');
    }


}
