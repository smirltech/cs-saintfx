<?php

namespace App\Models;

use App\Enums\MediaType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class DevoirReponse extends Model
{
    use HasFactory, HasUlids, HasUlids;

    public $guarded = [];

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

    public function setDocumentUrlAttribute(UploadedFile $file): void
    {
        $this->upload(file: $file, entity: $this, mediaType: MediaType::Document);
    }
}
