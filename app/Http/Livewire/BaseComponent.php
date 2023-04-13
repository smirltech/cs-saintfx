<?php

namespace App\Http\Livewire;

use App\Traits\HasLivewireAlert;
use App\Traits\WithFileUploads;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class BaseComponent extends Component
{
    use AuthorizesRequests, HasLivewireAlert, WithFileUploads;
}
