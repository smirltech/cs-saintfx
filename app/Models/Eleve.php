<?php

namespace App\Models;

use App\Enums\Sexe;
use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Eleve extends Model
{
    use HasFactory, HasUlids;

    public $guarded = [];
    protected $casts = [
        'sexe' => Sexe::class,
        'date_naissance' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    // generate matricule
    // {annee}{section_id}{count on section+1}
    //ex: 2022010001
    public static function generateMatricule(string $section_id): string
    {
        $annee = Annee::encours();
        $start_year = $annee->start_year;

        $first_part = $start_year . Helpers::pad($section_id);

        /*
        202202
        $count = Inscription::whereHas('classes', function ($query) use ($annee) {
               $query->where('section_id', $section_id);
           })->where('annee_id', $annee->id)->count();*/

        $count = Eleve::where('matricule', 'like', $first_part . '%')->count() + 1;

        $second_part = Helpers::pad($count, 4);

        return $first_part . $second_part;
    }

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    // full_name

    public function currentInscription()
    {
        return Inscription::where(['eleve_id' => $this->id, 'annee_id' => Annee::encours()->id])->first();
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->nom} {$this->postnom} {$this->prenom}";
    }

    public function responsable_eleve()
    {
        return $this->hasOne(ResponsableEleve::class);
    }

    // get profile url

    public function responsables(): HasManyThrough
    {
        return $this->hasManyThrough(Responsable::class, ResponsableEleve::class, 'eleve_id', 'id', 'id', 'responsable_id');
    }

    public function getProfileUrlAttribute(): ?string
    {
        return $this->avatar;
    }


    public function getAvatarAttribute()
    {
        return Helpers::fetchAvatar($this->full_name);
    }

    public function getSectionAttribute(): ?Section
    {
        return Section::find($this->section_id);
    }

    public function getCodeAttribute(): string
    {
        return $this->matricule;
    }


}
