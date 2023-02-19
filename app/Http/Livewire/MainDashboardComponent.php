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

    public $boxes = [];

    public function mount()
    {
       // return redirect(LoginController::redirectTo());

        $this->boxes = [
            [
                'title' => "Scolarité",
                'text' => 'Gestion école',
                'icon' => 'fas fa-fw fa-user-graduate',
                'url' => route('scolarite'),
                'theme' => 'danger',
            ],
            [
                'title' => "Finance",
                'text' => 'Gestion finance',
                'icon' => 'fas fa-fw fa-arrow-trend-up',
                'url' => route('finance'),
                'theme' => 'primary',
            ],
            [
                'title' => "Logistique",
                'text' => 'Gestion logistique',
                'icon' => 'fas fa-fw fa-recycle',
                'url' => route('logistique.materiels'),
                'theme' => 'warning',
            ],
            [
                'title' => "Bibliotheque",
                'text' => 'Gestion bibliotheque',
                'icon' => 'fas fa-fw fa-book',
                'url' => route('bibliotheque'),
                'theme' => 'success',
            ],

        ];
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.dashboard')->layoutData(['title'=> 'Accueil']);
    }

}
