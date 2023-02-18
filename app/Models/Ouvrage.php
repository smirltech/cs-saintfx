<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;
use SmirlTech\LaravelMedia\Traits\HasMedia;

class Ouvrage extends Model
{
    use HasFactory, HasMedia, HasUlids;

    public $guarded = [];

    public function ouvrageAuteurs(): HasMany|null
    {
        return $this->hasMany(
            related: OuvrageAuteur::class,
        );
    }

    public function auteurs(): HasManyThrough
    {
        return $this->hasManyThrough(
            related: Auteur::class,
            through: OuvrageAuteur::class,
            firstKey: 'ouvrage_id',
            secondKey: 'id',
            localKey: 'id',
            secondLocalKey: 'auteur_id',
        );
    }

    public function lectures(): HasMany
    {
        return $this->hasMany(Lecture::class)->with('user')->orderBy('created_at', 'desc');
    }

    public function getLecturesCountAttribute(): int
    {
        return $this->lectures->count();
    }

    public function getUniqueLecturesCountAttribute(): int
    {
        return $this->uniqueLectures()->count();
    }

    public function uniqueLectures(): Collection
    {
        return collect($this->lectures)->unique('user_id');
    }

    public function getLatestVisitAttribute()
    {
        return $this->lectures->first();
    }

    public function ouvrage_etiquettes(): HasMany|null
    {
        return $this->hasMany(
            OuvrageEtiquette::class,
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(OuvrageCategory::class, 'ouvrage_category_id');
    }

    public function getCategoryNomAttribute()
    {
        return $this->category?->nom;
    }

    public function deleteAllMedia(): void
    {
        $this->media->each->delete();
    }

}
