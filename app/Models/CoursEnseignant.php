<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursEnseignant extends Model
{
    use HasFactory;

    public $guarded = [];

    // saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function (CoursEnseignant $cours_enseignant) {
            $cours_enseignant->annee_id = Annee::encours()->id;
        });
    }
}
