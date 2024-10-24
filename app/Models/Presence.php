<?php

namespace App\Models;

use App\Enums\PresenceStatus;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LaracraftTech\LaravelDateScopes\DateScopes;
use SmirlTech\LaravelFullcalendar\Event;

class Presence extends Model
{
    use HasFactory, HasUlids, DateScopes;

    public $guarded = [];

    protected static function booted(): void
    {
        static::creating(function (Presence $presence) {
            if ($presence->annee_id == null) {
                $presence->annee_id = Annee::id();
            }
        });
    }

}
