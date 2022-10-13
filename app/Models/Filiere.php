<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $fillable =["nom", "description","code", "faculte_id"];

     /**
     * Get the user that owns the phone.
     */
    public function faculte()
    {
        return $this->belongsTo(Faculte::class);
    }

        /**
     * Get the comments for the blog post.
     */
    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }
}
