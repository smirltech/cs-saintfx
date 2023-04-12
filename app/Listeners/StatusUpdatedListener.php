<?php

namespace App\Listeners;

use App\Models\Depense;
use App\Notifications\DepenseCreated;
use Spatie\ModelStatus\Events\StatusUpdated;

class StatusUpdatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StatusUpdated $event): void
    {
        $model = $event->model;

        if ($model instanceof Depense) {
            $model->notifyAll(new DepenseCreated($model), $model->status_roles);
        }
    }
}
