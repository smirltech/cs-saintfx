<?php

namespace App\Traits;

use App\Enums\MediaType;
use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasMedia
{

    public function AddMedia(UploadedFile $file, MediaType $mediaType): Media
    {
        return $this->upload(file: $file, entity: $this, mediaType: $mediaType);
    }

    public function upload(UploadedFile $file, Model $entity, MediaType $mediaType): Media
    {
        return $entity->media()->create([
            'mime_type' => $file->getMimeType(),
            'filename' => $file->getClientOriginalName(),
            'location' => $file->store("{$entity->getTable()}/{$entity->id}/{$mediaType->folder()}", 'public'),
            'custom_property' => $mediaType->value,
            'size' => $file->getSize(),
        ]);
    }

    // set image attribute

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    // upload media

    public function setImageAttribute(UploadedFile $file): void
    {
        $this->upload(file: $file, entity: $this, mediaType: MediaType::image);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl();
    }

    public function getFirstMediaUrl(): string
    {
        $media = $this->getFirstMedia();

        return $media ? $media->getUrl() : '';
    }

    // get first media url

    public function getFirstMedia(): null|Media|MorphMany
    {
        return $this->media()->first();
    }

    // get first media

    public function getImageAttribute(): array
    {

        $image = $this->getFirstMedia();

        if ($image) {
            return [
                'name' => $image->filename,
                'url' => $image->url,
                'size' => $image->size,
            ];
        }
        return [];

    }

    public function delete(): ?bool
    {
        // prepare directory
        $directory = $this->getFirstMedia()->getDirectory();
        // delete files
        foreach ($this->media as $media) {
            $media->delete();
        }
        // remove folder and delete model
        if (Storage::disk('public')->deleteDirectory($directory)) {
            return parent::delete();
        }
    }


}
