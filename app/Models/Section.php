<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public $guarded = [];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function classes()
    {
        return $this->morphMany(Classe::class, 'filierable');
    }

    // full_name
    public function getFullNameAttribute(): string
    {
        return "{$this->nom}";
    }

    // full_name
    public function getFullCodeAttribute(): string
    {
        return "{$this->code}";
    }

    // full_name
    public function getShortCodeAttribute(): string
    {
        return substr("{$this->code}", 0, 1);
    }

    public function primaire($strict = false): bool
    {
        if ($strict && $this->id == 2) {
            return true;
        } elseif (! $strict && ($this->id == 1 || $this->id == 2)) {
            return true;
        }

        return false;
    }

    public function maternelle(): bool
    {
        if ($this->id == 1) {
            return true;
        }

        return false;
    }

    public function secondaire(): bool
    {
        if ($this->id == 3) {
            return true;
        }

        return false;
    }
}
