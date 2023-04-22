<?php

namespace App\Http\Livewire\Dashboard;

use App\Enums\UserRole;
use App\Models\Consommable;
use App\Models\Depense;
use App\Models\Enseignant;
use App\Models\Inscription;
use App\Models\Materiel;
use App\Models\Revenu;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AdminDashboardComponent extends Component
{
    public function mount(): void
    {

        $this->boxes = [
            [
                'title' => Inscription::anneeScolaire()->count(),
                'text' => 'Eleves',
                'icon' => 'fas fa-graduation-cap',
                'theme' => 'gradient-primary',
                'url' => '#'

            ],
            [
                'title' => Enseignant::count(),
                'text' => 'Enseignants',
                'icon' => 'fas fa-chalkboard-teacher',
                'theme' => 'gradient-info',
                'url' => '#'

            ],
            [
                'title' => User::count(),
                'text' => 'Personnels',
                'icon' => 'fas fa-user-tie',
                'theme' => 'gradient-warning',
                'url' => '#'

            ]
            ,
            [
                'title' => User::role(UserRole::parent->value)->count(),
                'text' => 'Parents',
                'icon' => 'fas fa-users',
                'theme' => 'gradient-info',
                'url' => '#'

            ],
            [
                'title' => '$' . Depense::total(),
                'text' => 'Depenses',
                'icon' => 'fas fa-credit-card',
                'theme' => 'gradient-danger',
                'url' => '#'

            ],
            [
                'title' => '$' . Revenu::total(),
                'text' => 'Revenus',
                'icon' => 'fas fa-coins',
                'theme' => 'gradient-success',
                'url' => '#'

            ],
            [
                'title' => Consommable::count(),
                'text' => 'Consommables',
                'icon' => 'fas fa-utensils',
                'theme' => 'gradient-primary',
                'url' => '#'

            ],
            [
                'title' => Materiel::count(),
                'text' => 'Materiels',
                'icon' => 'fas fa-tools',
                'theme' => 'gradient-warning',
                'url' => '#'

            ]
        ];
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.dashboard.admin-dashboard-component');
    }
}
