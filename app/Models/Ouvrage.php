<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;
use SmirlTech\LaravelMedia\Traits\HasMainImage;
use Spatie\Tags\HasTags;

class Ouvrage extends Model
{
    use HasFactory, HasMainImage, HasUlids, HasTags;

    public $guarded = [];

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

    public function category(): BelongsTo
    {
        return $this->belongsTo(OuvrageCategory::class, 'ouvrage_category_id');
    }

    public function getCategoryNomAttribute()
    {
        return $this->category?->nom;
    }

    public function deleteAllMedia(?string $collection_name = null): void
    {
        if ($collection_name)
            $this->media()->where('collection_name', $collection_name)->delete();
        else
            $this->media->each->delete();
    }

    public function setAuteursAttribute(?array $value): void
    {
        $this->ouvrageAuteurs()->delete();
        if ($value) {
            foreach ($value as $auteur) {
                $this->ouvrageAuteurs()->create(['auteur_id' => $auteur]);
            }
        }
    }

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

    public function setTagsAttribute(?array $tags): void
    {
        if ($tags) {
            $this->tags()->sync($tags);
        }
    }


}
