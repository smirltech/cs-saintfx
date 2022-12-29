<?php

namespace App\Models;

use App\Enums\Sexe;
use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use JetBrains\PhpStorm\Pure;

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

    // route model binding

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


    // generate matricule
    // {annee}{section_id}{count on section+1}
    //ex: 2022010001

    public static function nonInscritsAnneeEnCours()
    {
        return self::whereDoesntHave('inscriptions', function ($q) {
            $q->where('annee_id', Annee::id());
        })->get();
    }

    public function getRouteKeyName()
    {
        return 'matricule';
    }

    public function getPresencesAttribute(): Collection
    {
        return $this->inscription->presences;
    }

    public function getPresenceColorsAttribute(): array
    {
        $aa = [];
        foreach($this->inscription->presences as $p){
            $aa[] = $p->getColor();
        }
        return $aa;
    }

    public function getInscriptionAttribute(): Inscription
    {
        return $this->inscriptions()->where('annee_id', Annee::id())->first();
    }

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    public function resultats(): HasManyThrough
    {
        return $this->hasManyThrough(Resultat::class, Inscription::class)->orderBy('custom_property');
    }

    public function resultatsThisYear()
    {
        return $this->resultats->where('annee_id', Annee::id());
    }

    public function resultatsOfYear($annee_id)
    {
        return $this->resultats->where('annee_id', $annee_id);
    }

    // full_name

    public function currentInscription(): Inscription
    {
        return Inscription::where(['eleve_id' => $this->id, 'annee_id' => Annee::encours()->id])->first();
    }

    #[Pure] public function getNomCompletAttribute(): string
    {
        return $this->getFullNameAttribute();
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->nom} {$this->postnom} {$this->prenom}";
    }

    public function responsable_eleve(): HasOne
    {
        return $this->hasOne(ResponsableEleve::class);
    }

    // get profile url

    public function responsables(): HasManyThrough
    {
        return $this->hasManyThrough(Responsable::class, ResponsableEleve::class, 'eleve_id', 'id', 'id', 'responsable_id');
    }

    public function perceptions(): HasManyThrough
    {
        return $this->hasManyThrough(Perception::class, Inscription::class);
    }

    public function getProfileUrlAttribute(): ?string
    {
        return $this->avatar;
    }


    public function getAvatarAttribute(): string
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

    // MONTANTS
    public function getPerceptionsDuesAttribute(): int
    {
        return $this->inscriptions->sum('perceptionsDues');
    }

    public function getPerceptionsPaidAttribute(): int
    {
        return $this->inscriptions->sum('perceptionsPaid');
    }

    public function getPerceptionsBalanceAttribute(): int
    {
        return $this->inscriptions->sum('perceptionsBalance');
    }
}
