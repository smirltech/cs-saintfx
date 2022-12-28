<?php

namespace App\Models;

use App\Enums\PresenceStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory, HasUlids;

    public $guarded = [];
    protected $casts = [
        'status' => PresenceStatus::class,

    ];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }
}
