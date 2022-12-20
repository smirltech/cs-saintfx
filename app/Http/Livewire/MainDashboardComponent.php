<?php

namespace App\Http\Livewire;

use App\Enums\UserRole;
use Auth;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Redirector;

class MainDashboardComponent extends Component
{

    public function mount(): RedirectResponse|Redirector
    {
        $me = Auth::user();
        if ($me->role == UserRole::caissier) {
            return redirect()->route('finance');
        } else {
            return redirect()->route('scolarite');
        }
    }

}
