<?php

namespace App\Models;

use App\Enum\EleveSexe;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Eleve extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'sexe' => EleveSexe::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    // full_name
    public function getFullNameAttribute(): string
    {
        return "{$this->nom} {$this->postnom} {$this->prenom}";
    }
}
