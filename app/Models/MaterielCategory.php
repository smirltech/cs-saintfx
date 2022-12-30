<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterielCategory extends Model
{
    use HasFactory;

    public $guarded = [];

    public function groupe(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    public function materiels(): HasMany
    {
        return $this->hasMany(Materiel::class);
    }
}
