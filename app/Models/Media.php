<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Media extends Model
{

    protected $guarded = [];

    protected $hidden = ['mediable_type', 'mediable_id'];

    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function mediable()
    {
        return $this->morphTo();
    }

    public function getPathAttribute(): string
    {
        return $this->getUrlAttribute();
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->location);

    }

    public function delete(): ?bool
    {
        $bool = Storage::disk('public')->delete($this->location);

        if ($bool) {
            return parent::delete();
        }

    }

    // get Url

    public function getUrl(): string
    {
        return $this->getUrlAttribute();
    }

    // get directory

    public function getDirectory(): string
    {
        // extract the file location from the media location
        $location = $this->location;
        $parts = explode('/', $location);

        // build string and ignore last part
        $directory = '';
        foreach ($parts as $key => $part) {
            $directory .= $part;
            if ($key === count($parts) - 2) {
                break;
            } else {
                $directory .= '/';
            }
        }

        return $directory;
    }

}
