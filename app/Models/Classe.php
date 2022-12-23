<?php

namespace App\Models;

use App\Enums\ClasseGrade;
use App\Enums\ResultatType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class)->where('annee_id', Annee::encours()->id);
    }

    /*
     * Return a list of inscriptions sorted by place of the results as of type
     */
    public function inscriptionsAsOfPlaceOfResultats(ResultatType $resultatType)
    {
        $inscriptions_temp = $this->inscriptions->all();
        usort($inscriptions_temp, function ($insc1, $insc2) use ($resultatType) {
            $r1 = $insc1->resultats->where('custom_property', $resultatType)->first();
            $r2 = $insc2->resultats->where('custom_property', $resultatType)->first();
            return $r1?->place > $r2?->place;
        });
        return $inscriptions_temp;
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

    public function getFullReverseNameAttribute(): string
    {
        return "{$this->grade->value} {$this->filierable->fullName}";
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
    public function primaire($strict = false): bool
    {
        return $this->section->primaire(strict:$strict);
    }

    public function maternelle(): bool
    {
        return $this->section->maternelle();
    }

    public function secondaire(): bool
    {
        return $this->section->secondaire();
    }
}
