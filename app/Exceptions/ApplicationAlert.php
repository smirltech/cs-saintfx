<?php

namespace App\Exceptions;

use App;
use Jantinnerezo\LivewireAlert\LivewireAlert;

trait ApplicationAlert
{
    use LivewireAlert;


    public function error(string $local, string $production): void
    {

        $this->dispatchOrFlashAlert([
            'type' => 'error',
            'message' => App::hasDebugModeEnabled() ? $local : $production,
            'options' => [
                'toast' => false,
                'duration' => 10000,
            ]
        ]);
    }
}
