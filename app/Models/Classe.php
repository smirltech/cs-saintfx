<?php

namespace App\Models;

use App\Enums\ClasseGrade;
use App\Enums\FraisType;
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

    /*
     * Return a list of inscriptions sorted by place of the results as of type
     */

    public function eleves(): BelongsToMany
    {
        return $this->belongsToMany(Eleve::class, 'inscriptions')->where('annee_id', Annee::encours()->id);
    }

    // eleves

    public function getFullNameAttribute(): string
    {
        return "{$this->filierable?->fullName} {$this->grade->value}";
    }

    // full_name

    public function getFullReverseNameAttribute(): string
    {
        return "{$this->grade->value} - {$this->filierable?->fullName}";
    }

    public function getNomAttribute(): string
    {
        return $this->full_reverse_name;
    }

    public function getFullCodeAttribute(): string
    {
        return "{$this->grade->value} {$this->filierable?->fullCode}";
    }


    // full_name

    public function getShortCodeAttribute(): string
    {
        return "{$this->grade->value} {$this->filierable?->shortCode}";
    }

    // full_name

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

    // parent_url

    public function enseignantsPrimaire(): BelongsToMany
    {
        return $this->belongsToMany(Enseignant::class, 'classe_enseignants')->where('annee_id', Annee::encours()->id);
    }

    public function enseignants(): BelongsToMany
    {
        return $this->belongsToMany(Enseignant::class, 'cours_enseignants')->where('annee_id', Annee::encours()->id);
    }

    public function cours(): BelongsToMany
    {
        return $this->belongsToMany(Cours::class, 'cours_enseignants')->where('annee_id', Annee::encours()->id)->withPivot('classe_id');
    }


    // cours

    public function coursEnseignants(): HasMany
    {
        return $this->hasMany(CoursEnseignant::class)->where('annee_id', Annee::encours()->id);
    }

    public function getSectionIdAttribute(): ?int
    {
        $classable = $this->filierable;
        if ($classable instanceof Filiere) {
            return $classable->option->section_id;
        } else if ($classable instanceof Option) {
            return $classable->section_id;
        } else if ($classable instanceof Section) {
            return $classable->id;
        }
        return null;
    }

    public function getOptionIdAttribute(): ?int
    {
        $classable = $this->filierable;
        if ($classable instanceof Filiere) {
            return $classable->option->id;
        } else if ($classable instanceof Option) {
            return $classable->id;
        }
        return null;
    }

    public function getFiliereIdAttribute(): ?int
    {
        $classable = $this->filierable;
        if ($classable instanceof Filiere) {
            return $classable->id;
        }
        return null;
    }


    // get section id from filierable attribute

    public function getSectionAttribute(): ?Section
    {
        return Section::find($this->section_id);
    }

    // get section from section_id attribute

    public function getEnseignantIdAttribute(): ?string

    {
        return $this->enseignantsPrimaire->first()?->pivot->enseignant_id;
    }

    // get enseignant id from classe enseignant pivot table

    public function getEnseignantAttribute(): ?Enseignant
    {
        return Enseignant::find($this->enseignant_id);
    }

    // get enseignant from enseignant_id attribute

    public function primaire($strict = false): bool
    {
        return $this->section->primaire(strict: $strict);
    }

    // function primaire

    public function maternelle(): bool
    {
        return $this->section->maternelle();
    }

    public function secondaire(): bool
    {
        return $this->section->secondaire();
    }

    public function presences()
    {
        return $this->hasManyThrough(Presence::class, Inscription::class)->with('inscription');
    }

    public function nonInscriptions($date)
    {
        $df = $this->inscriptions()->whereDoesntHave('presences', function ($q) use ($date) {
            $q->where('date', $date);
        })->get();
        //  dd($df);
        return $df;
    }

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class)->where('annee_id', Annee::encours()->id);
    }

    // get frais inscription attribute
    public function getFraisInscriptionAttribute(): ?Frais
    {
        $annee_id = Annee::id();

        $frais = Frais::where('annee_id', $annee_id)
            ->where('type', FraisType::inscription)
            ->where('classable_type', 'like', '%Classe')
            ->where('classable_id', $this->id)
            ->first();
        if ($frais != null) {
            return $frais;
        }


        if ($this->filiere_id) {
            $frais = Frais::where('annee_id', $annee_id)
                ->where('type', FraisType::inscription)
                ->where('classable_type', 'like', '%Filiere')
                ->where('classable_id', $this->filiere_id)
                ->orderBy('nom')
                ->first();
            if ($frais != null) {
                return $frais;
            }
        }

        if ($this->option_id) {
            $frais = Frais::where('annee_id', $annee_id)
                ->where('type', FraisType::inscription)
                ->where('classable_type', 'like', '%Option')
                ->where('classable_id', $this->option_id)
                ->first();
            if ($frais != null) {
                return $frais;
            }
        }
        if ($this->section_id) {
            $frais = Frais::where('annee_id', $annee_id)
                ->where('type', FraisType::inscription)
                ->where('classable_type', 'like', '%Section')
                ->where('classable_id', $this->section_id)
                ->first();
            if ($frais != null) {
                return $frais;
            }
        }
        return null;
    }


}
