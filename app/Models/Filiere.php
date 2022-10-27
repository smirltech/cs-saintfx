<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $with=['option'];

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

    // full_name
    public function getFullCodeAttribute(): string
    {
        return "{$this->option->fullCode} {$this->code}";
    }

    // full_name
    public function getShortCodeAttribute(): string
    {
        return "{$this->option->shortCode}".substr("{$this->code}", 0, 1) ;
    }

    /**
     * Get the comments for the blog post.
     */
   /* public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }*/
}
