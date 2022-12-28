<?php

namespace App\Models;

use App\Enums\PresenceStatus;
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

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        // TODO: Implement getTitle() method.
    }

    /**
     * @inheritDoc
     */
    public function isAllDay(): bool
    {
        // TODO: Implement isAllDay() method.
    }

    /**
     * @inheritDoc
     */
    public function getStart(): DateTime
    {
        // TODO: Implement getStart() method.
    }

    /**
     * @inheritDoc
     */
    public function getEnd(): DateTime
    {
        // TODO: Implement getEnd() method.
    }
}
