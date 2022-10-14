<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    public $guarded = [];

    /*
     * Get parents that can be Section, Option or Filiere
     * */
    public function filierable(){
        return $this->morphTo();
    }
}
