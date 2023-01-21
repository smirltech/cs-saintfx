<?php

namespace App\Http\Livewire;

use App\Exceptions\ApplicationAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class BaseComponent extends Component
{
    use AuthorizesRequests, ApplicationAlert;
}
