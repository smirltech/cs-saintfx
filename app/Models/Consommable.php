<?php

namespace App\Models;

use App\Enums\MouvementStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consommable extends Model
{
    use HasFactory;

    public $guarded = [];
    public $with = ['operations'];

    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class)->orderBy('date', 'DESC');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function getQuantiteInAttribute(): int|null
    {
        return $this->operations()->where('direction', MouvementStatus::in->name)->sum('quantite');

    }

    public function getQuantiteOutAttribute(): int|null
    {
        return $this->operations()->where('direction', MouvementStatus::out->name)->sum('quantite');

    }

    public function getQuantiteAttribute(): int
    {
        return (int)($this->quantiteIn??0) - (int)($this->quantiteOut??0);

    }
}
