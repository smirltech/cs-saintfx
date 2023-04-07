<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\ModelStatus\Status as SpatieStatus;

class Status extends SpatieStatus
{
    use HasUlids;

    public $guarded = [];
}
