<?php

namespace App\Models;

use App\Enums\Sexe;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auteur extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $casts = ['sexe' => Sexe::class,];

    public function ouvrage_auteur(): HasMany|null
    {
        return $this->hasMany(OuvrageAuteur::class);
    }
}
