<?php

namespace App\Models;

use App\Enums\ClasseGrade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Classe extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'grade' => ClasseGrade::class,

    ];


    /*
     * Get parents that can be Section, Option or Filiere
     * */
    public function filierable(): MorphTo
    {
        return $this->morphTo();
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class)->where('annee_id', Annee::encours()->id);
    }

    // eleves
    public function eleves(): BelongsToMany
    {
        return $this->belongsToMany(Eleve::class, 'inscriptions')->where('annee_id', Annee::encours()->id);
    }

    // full_name
    public function getFullNameAttribute(): string
    {
        return "{$this->filierable->fullName} {$this->grade->value}";
    }

    // full_name
    public function getFullCodeAttribute(): string
    {
        return "{$this->grade->value} {$this->filierable->fullCode}";
    }

    // full_name
    public function getShortCodeAttribute(): string
    {
        return "{$this->grade->value} {$this->filierable->shortCode}";
    }

    // parent_url
    public function getParentUrlAttribute(): ?string
    {
        $parent_url = "";
        $classable = $this->filierable;
        if ($classable instanceof Filiere) {
            $parent_url = route('scolarite.filieres.show', $classable->id);
        } else if ($classable instanceof Option) {
            $parent_url = route('scolarite.options.show', $classable->id);
        } else if ($classable instanceof Section) {
            $parent_url = route('scolarite.sections.show', $classable->id);
        }

        return $parent_url;
    }

    public function enseignantsPrimaire(): BelongsToMany
    {
        return $this->belongsToMany(Enseignant::class, 'classe_enseignants')->where('annee_id', Annee::encours()->id);
    }

    public function enseignants(): BelongsToMany
    {
        return $this->belongsToMany(Enseignant::class, 'cours_enseignants')->where('annee_id', Annee::encours()->id);
    }


    // cours

    public function cours(): BelongsToMany
    {
        return $this->belongsToMany(Cours::class, 'cours_enseignants')->where('annee_id', Annee::encours()->id)->withPivot('classe_id');
    }


    // get section id from filierable attribute
    public function getSectionIdAttribute(): ?int
    {
        $section_id = null;
        $classable = $this->filierable;
        if ($classable instanceof Filiere) {
            $section_id = $classable->option->section_id;
        } else if ($classable instanceof Option) {
            $section_id = $classable->section_id;
        } else if ($classable instanceof Section) {
            $section_id = $classable->id;
        }

        return $section_id;
    }

    // get section from section_id attribute
    public function getSectionAttribute(): ?Section
    {
        return Section::find($this->section_id);
    }

    // get enseignant id from classe enseignant pivot table
    public function getEnseignantIdAttribute(): ?string

    {
        return $this->enseignantsPrimaire->first()?->pivot->enseignant_id;
    }

    // get enseignant from enseignant_id attribute
    public function getEnseignantAttribute(): ?Enseignant
    {
        return Enseignant::find($this->enseignant_id);
    }

    // function primaire
    public function primaire(): bool
    {
        return $this->section->primaire();
    }


}
