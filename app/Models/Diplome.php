<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diplome extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $casts = [
        'date_delivrance' => 'datetime',
    ];

    /**
     * Get the user that owns the phone.
     */
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

}
