<?php

namespace App\Models;

use App\Enums\PresenceStatus;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SmirlTech\LaravelFullcalendar\Event;

class Presence extends Model implements Event
{
    use HasFactory, HasUlids;

    public $guarded = [];
    protected $casts = [
        'status' => PresenceStatus::class,

    ];

    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

    // get eleve attribute from inscription
    public function getEleveAttribute()
    {
        return $this->inscription->eleve;
    }


    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->status->label();
    }

    /**
     * @inheritDoc
     */
    public function isAllDay(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getStart(): DateTime
    {
        // set start time to 8:00 from presence date
        return Carbon::parse($this->date)->setTime(8, 0);
    }

    /**
     * @inheritDoc
     */
    public function getEnd(): DateTime
    {
        //set start time to 13:00 from presence date
        return Carbon::parse($this->date)->setTime(13, 0);
    }

    /**
     * @inheritDoc
     */
    public function getId(): int|string|null
    {
        return $this->id;
    }
}
