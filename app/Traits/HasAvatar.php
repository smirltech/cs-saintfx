<?php

namespace App\Traits;

use App\Helpers\Helpers;
use SmirlTech\LaravelMedia\Traits\HasMedia;

trait HasAvatar
{
    use HasMedia;

    public function getProfileUrlAttribute(): ?string
    {
        return $this->avatar;
    }


    public function getAvatarAttribute(): string
    {
        return $this->image ?? Helpers::fetchAvatar($this->full_name ?? $this->name);
    }


}
