<?php

namespace App\Models;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    public $guarded = [];

    // section
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // avatar
    public function getAvatarAttribute()
    {
        return Helpers::fetchAvatar($this->nom);
    }

    // classe
    public function classes()
    {
        return $this->belongsToMany(Classe::class);
    }
}
