<?php

namespace App\Listeners;

use App\Models\Depense;
use App\Notifications\DepenseCreated;

class StatusUpdated
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
        $status = $event->status;
        $model = $status->model;

        if ($model instanceof Depense) {
            $model->notifyAll(new DepenseCreated($model), $model->status_roles);
        }
    }
}
