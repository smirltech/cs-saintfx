<?php

namespace App\Models;

use App\Enum\ClasseGrade;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'grade' => ClasseGrade::class,

    ];

    /*
     * Get parents that can be Section, Option or Filiere
     * */
    public function filierable(){
        return $this->morphTo();
    }
}
