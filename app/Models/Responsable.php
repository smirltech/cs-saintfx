<?php

namespace App\Models;

use App\Enums\Sexe;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    use HasFactory, HasUlids;

    public $guarded = [];
    protected $casts = [
        'sexe' => Sexe::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function responsable_eleves()
    {
        return $this->hasMany(ResponsableEleve::class);
    }

    public function getDetailAttribute(): string
    {
        return "{$this->nom} - Phone:({$this->telephone}) - Adresse:({$this->adresse})";
    }

}
