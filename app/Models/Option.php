<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Option extends Model
{

    public $guarded = [];

    public function classes(): MorphMany
    {
        return $this->morphMany(Classe::class, 'filierable');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    // full_name
    public function getFullNameAttribute(): string
    {
        return "{$this->section->fullName} - {$this->nom}";
    }

    // full_name
    public function getFullCodeAttribute(): string
    {
        return "{$this->section->fullCode} {$this->code}";
    }

    // full_name
    public function getShortCodeAttribute(): string
    {
        return substr("{$this->code}", 0, 1);
    }
}
