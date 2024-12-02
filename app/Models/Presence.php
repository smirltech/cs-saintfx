<?php

namespace App\Models;

use App\Enums\PresenceStatus;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
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


    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public static function lastTotal(): int
    {
        // get the last total presence for last available date
        $maxMat = Presence::whereHas('classe', function ($query) {
            $query->where('section_id', 1);
        })->max('date');

        $mat = Presence::where('date', $maxMat)->whereHas('classe', function ($query) {
            $query->where('section_id', 1);
        })->sum('total');

        $maxP = Presence::whereHas('classe', function ($query) {
            $query->where('section_id', 2);
        })->max('date');


        $p = Presence::where('date',$maxP)->whereHas('classe', function ($query) {
            $query->where('section_id', 2);
        })->sum('total');

        $maxP = Presence::whereHas('classe', function ($query) {
            $query->where('section_id', 3);
        })->max('date');

        $sec = Presence::where('date', $maxP)->whereHas('classe', function ($query) {
            $query->where('section_id', 3);
        })->sum('total');

        return $mat + $p + $sec;
    }

}
