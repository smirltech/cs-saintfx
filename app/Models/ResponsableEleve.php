<?php

namespace App\Models;

use App\Enum\ResponsableRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ResponsableEleve extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $casts = [
        'relation' => ResponsableRelation::class,

    ];

    public function responsable()
    {
        return $this->belongsTo(Responsable::class);
    }

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
}
