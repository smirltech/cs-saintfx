<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ouvrage extends Model
{
    use HasFactory;

    public $guarded = [];

    public function category():BelongsTo
    {
        return $this->belongsTo(OuvrageCategory::class, 'ouvrage_category_id');
    }

    public function getCategoryNomAttribute(){
        return $this->category?->nom;
    }
}
