<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends SpatieRole
{
    // get name attribute
    public function getDisplayNameAttribute()
    {
        return __(Str::title(str_replace('-', ' ', $this->name)));
    }
}