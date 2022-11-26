<?php

namespace App\Models;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    public $guarded = [];

    // section
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // avatar
    public function getAvatarAttribute()
    {
        return Helpers::fetchAvatar($this->nom);
    }

    // classes

    public function getClasseAttribute()
    {
        return $this->classes()->where('annee_id', Annee::encours()->id)->first();
    }

    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_enseignants');
    }

    // cours

    public function cours()
    {
        return $this->belongsToMany(Cours::class, 'cours_enseignants')->where('annee_id', Annee::encours()->id)->withPivot('classe_id');
    }

    public function scopeClasse(Builder $query, Classe $classe): Builder
    {
        // cours where section_id = classe.section_id and not in cours_enseignants where classe_id = classe.id and annee_id = annee encours
        return $query->where('section_id', $classe->section_id);
    }

    // primaire
    public function primaire(): bool
    {
        if ($this->section->id == 1 || $this->section->id == 2) {
            return true;
        }
        return false;
    }
}
