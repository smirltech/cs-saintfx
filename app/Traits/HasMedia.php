<?php

namespace App\Traits;

use App\Enum\MediaType;
use App\Models\Media;

trait HasMedia
{
    public function getImageSmallAttribute(): string
    {
        $first_image = $this->media()->latest()->first();

        return $first_image ? $first_image->path : asset('images/no-image.png');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function getImageAttribute()
    {

        $image = $this->media()->where('custom_property', MediaType::image->name)->latest()->first();

        if ($image) {
            return $image->path;
        }
        return null;
    }
}
