<?php

namespace App\Http\Livewire\Dashboard;

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
                'title' => 0,
                'text' => 'Revenu du mois',
                'icon' => 'fas fa-money-bill-wave',
                'theme' => 'gradient-primary',
                'url' => '#'

            ]];
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.dashboard.admin-dashboard-component');
    }
}
