<?php

namespace App\Models;

use App\Enums\AuditEvent;
use Date;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model implements \OwenIt\Auditing\Contracts\Audit
{
    use \OwenIt\Auditing\Audit;


    protected $guarded = [];

    protected $casts = [
        'event' => AuditEvent::class,
        'old_values' => 'json',
        'new_values' => 'json',
        'auditable_id' => 'integer',
    ];

    // create a createdAt attribute use dif for human readable date
    public function getDisplayDateAttribute()
    {
        return Date::parse($this->created_at)->diffForHumans();
    }
}
