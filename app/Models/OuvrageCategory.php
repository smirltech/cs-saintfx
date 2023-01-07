<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OuvrageCategory extends Model
{
    use HasFactory;

    public $guarded = [];

    public function groupe():BelongsTo
    {
        return $this->belongsTo(self::class, 'ouvrage_category_id');
    }

    public function getGroupeNomAttribute(){
        return $this->groupe?->nom;
    }
}
