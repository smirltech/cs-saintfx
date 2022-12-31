<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Operation extends Model
{
    use HasFactory;

    public $guarded = [];

    public function consommable(): BelongsTo
    {
        return $this->belongsTo(Consommable::class);
    }
}
