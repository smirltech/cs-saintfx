<?php

namespace App\Models;

use App\Enum\MediaType;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

    protected $guarded = [];

    protected $hidden = ['mediable_type', 'mediable_id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'custom_property' => MediaType::class
    ];

    // mediables
    public function mediable()
    {
        return $this->morphTo();
    }

    // created at attribute
    // then format it to be human readable
    // return days ago, hours ago, minutes ago, seconds ago
    // $media->createdAt
    /*  public function getCreatedAtAttribute(): string
  /*  {
          return $this->created_at->diffForHumans();
      }*/

    // Create location attribute
    // return the location of the media
    // $media->path
    //
    public function getPathAttribute(): string
    {
        return asset("storage/{$this->location}");
    }
}
