<?php

namespace App\Models;

use App\Enums\Sexe;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Auteur extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $casts = ['sexe' => Sexe::class,];
}
