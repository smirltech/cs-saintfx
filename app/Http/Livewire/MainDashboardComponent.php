<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Auth\LoginController;
use App\Traits\TopMenuPreview;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Redirector;

class MainDashboardComponent extends Component
{
    use TopMenuPreview;

    public function mount(): RedirectResponse|Redirector
    {
        return redirect(LoginController::redirectTo());
    }

}
