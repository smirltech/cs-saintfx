<?php

namespace App\Models;

use App\Helpers\Helpers;
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
        return $this->belongsToMany(Cours::class, 'cours_enseignants')->where('annee_id', Annee::encours()->id);
    }
}
