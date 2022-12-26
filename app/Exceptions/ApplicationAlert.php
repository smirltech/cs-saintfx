<?php

namespace App\Exceptions;

use App;
use Jantinnerezo\LivewireAlert\Exceptions\AlertException;
use Jantinnerezo\LivewireAlert\LivewireAlert;

trait ApplicationAlert
{
    use LivewireAlert;


    /**
     * @throws AlertException
     */
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

    /**
     * @throws AlertException
     */
    public function success(string $message, array $options = []): void
    {

        $this->dispatchOrFlashAlert([
            'type' => 'success',
            'message' => $message,
            'options' => $options
        ]);
    }
}
