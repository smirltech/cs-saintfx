<?php

namespace App\Models;

use App\Enums\MediaType;
use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rules\In;

class Resultat extends Model
{
    use HasFactory, HasUlids, HasMedia;

    public $guarded = [];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    public function getBulletinAttribute(): ?Media
    {
        return $this->getBulletin();
    }

    public function getBulletin(): ?Media
    {
        return $this->getFirstMedia();
    }

    // get bulletin attribute
    public function getBulletinUrlAttribute(): string
    {
        return $this->getFirstMediaUrl();
    }

    public function setBulletinUrlAttribute(UploadedFile $file): void
    {
        $this->upload(file: $file, entity: $this, mediaType: MediaType::bulletin);
    }
}
