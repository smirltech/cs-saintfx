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
            $parent_url = route('admin.filieres.show', $classable->id);
        } else if ($classable instanceof Option) {
            $parent_url = route('admin.options.show', $classable->id);
        } else if ($classable instanceof Section) {
            $parent_url = route('admin.sections.show', $classable->id);
        }

        return $parent_url;
    }

    public function enseignants(): BelongsToMany
    {
        return $this->belongsToMany(Enseignant::class, 'classe_enseignants')->where('annee_id', Annee::encours()->id);
    }

    // cours

    public function cours(): BelongsToMany
    {
        return $this->belongsToMany(Cours::class, 'cours_enseignants')->where('annee_id', Annee::encours()->id)->withPivot('classe_id');
    }
}
