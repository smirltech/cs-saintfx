<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Ouvrage extends Model
{
    use HasFactory;

    public $guarded = [];

    public function ouvrage_auteurs(): HasMany|null
    {
        return $this->hasMany(
            OuvrageAuteur::class,
        );
    }

    public function ouvrage_etiquettes(): HasMany|null
    {
        return $this->hasMany(
            OuvrageEtiquette::class,
        );
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(OuvrageCategory::class, 'ouvrage_category_id');
    }

    public function getCategoryNomAttribute(){
        return $this->category?->nom;
    }
}
