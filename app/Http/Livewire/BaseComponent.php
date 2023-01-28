<?php

namespace App\Http\Livewire;

use App\Traits\HasLivewireAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class BaseComponent extends Component
{
    use AuthorizesRequests, HasLivewireAlert;
}
