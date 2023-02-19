<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Auth\LoginController;
use App\Traits\TopMenuPreview;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Redirector;

class MainDashboardComponent extends Component
{
    use TopMenuPreview;

    public function mount()
    {
       // return redirect(LoginController::redirectTo());
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.dashboard')->layoutData(['title'=> 'Accueil']);
    }

}
