<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'filiere_codes' => 'json'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function filieres()
    {
        return $this->hasMany(Filiere::class);
    }

    public function classes(){
        return $this->morphMany(Classe::class, 'filierable');
    }
}
