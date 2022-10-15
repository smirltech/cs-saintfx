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

    public function classes(){
        return $this->morphMany(Classe::class, 'filierable');
    }

    // full_name
    public function getFullNameAttribute(): string
    {
        return "{$this->nom}";
    }
}
