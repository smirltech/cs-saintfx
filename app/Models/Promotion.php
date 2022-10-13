<?php

namespace App\Models;

use App\Enum\PromotionGrade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $casts = [
        'grade' => PromotionGrade::class,
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }
}
