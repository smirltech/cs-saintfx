<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    public $guarded = [];

    /**
     * Get the user that owns the phone.
     */
    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function classes(){
        return $this->morphMany(Classe::class, 'filierable');
    }

    // full_name
    public function getFullNameAttribute(): string
    {
        return "{$this->option->fullName} {$this->nom}";
    }

    /**
     * Get the comments for the blog post.
     */
   /* public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }*/
}
