<?php

namespace App\Models;

use App\Enums\Sexe;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auteur extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $casts = ['sexe' => Sexe::class,];

    public function ouvrage_auteur(): HasMany|null
    {
        return $this->hasMany(OuvrageAuteur::class);
    }

    public function ouvrages(): \Illuminate\Database\Eloquent\Relations\HasManyThrough|null
    {
        return $this->hasManyThrough(Ouvrage::class, OuvrageAuteur::class, 'auteur_id', 'id', 'id', 'ouvrage_id');
    }

    public function getOuvragesCountAttribute(): int
    {
        return $this->ouvrages()->count();
    }

    public function getFullNameAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }
}
