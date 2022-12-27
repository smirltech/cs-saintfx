<?php

namespace App\Exceptions;

use App;
use Jantinnerezo\LivewireAlert\LivewireAlert;

trait ApplicationAlert
{
    use LivewireAlert;


    /**
     * @param string $local
     * @param string $production
     */
    public function error(string $local, string $production): void
    {
        $this->alert('error', App::hasDebugModeEnabled() ? $local : $production, [
            'toast' => false,
            'duration' => 10000,
        ]);
    }

    /**
     * @param string $message
     * @param array $options
     */
    public function success(string $message, array $options = []): void
    {

        $this->alert('success', $message, $options);
    }

    /**
     * @param string $message
     * @param array $options
     * @return void
     */
    private function warning(string $message, array $options = []): void
    {

        $this->alert('warning', $message, $options);
    }
}
