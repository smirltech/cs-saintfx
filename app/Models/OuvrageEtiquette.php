<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OuvrageEtiquette extends Model
{
    use HasFactory;

    public $guarded = [];


    public function etiquette(): BelongsTo|null
    {
        return $this->belongsTo(Tag::class);
    }

    public function getNomAttribute(): string|null
    {
        return $this->etiquette->nom;
    }

    public function ouvrage(): BelongsTo|null
    {
        return $this->belongsTo(Ouvrage::class);
    }

}
