<?php

namespace App\Models;

use App\Enums\ClasseGrade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        return $this->hasMany(Inscription::class);
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
}
