<?php

namespace App\Models;

use App\Enums\DevoirStatus;
use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devoir extends Model
{
    use HasFactory, HasUlids, HasMedia;

    public $guarded = [];

    protected $casts = [
        'echeance' => 'datetime',
        'status' => DevoirStatus::class,
    ];

    public function getDocumentAttribute(): ?Media
    {
        return $this->getDocument();
    }

    public function getDocument(): ?Media
    {
        return $this->getFirstMedia();
    }

    // get Document attribute
    public function getDocumentUrlAttribute(): string
    {
        return $this->getFirstMediaUrl();
    }

    // get devoirEleves relation
    public function devoirEleves(): HasMany
    {
        return $this->hasMany(DevoirReponse::class);
    }

    // cours
    public function cours(): BelongsTo
    {
        return $this->belongsTo(Cours::class);
    }

    // classe
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    // display echeance
    public function getEcheanceDisplayAttribute(): string
    {
        return $this->echeance->diffForHumans();
    }
}
