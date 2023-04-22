<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Auth;
use Illuminate\Http\Request;

class DashboardController
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        return match ($user->role_name) {
            UserRole::promoteur->value, UserRole::coordonnateur->value, UserRole::admin->value => $this->adminDashboard(),
            UserRole::comptable->value => $this->compableDashboard(),
            UserRole::parent->value => $this->parentDashboard(),
            UserRole::eleve->value => $this->eleveDashboard(),
            UserRole::enseignant->value => $this->enseignantDashboard(),
            default => $this->defaultDashboard()
        };
    }

    private function adminDashboard()
    {
        return view('dashboard.admin');
    }

    private function compableDashboard()
    {
        return view('dashboard.comptable');
    }

    private function parentDashboard()
    {
        return view('dashboard.parent');
    }

    private function eleveDashboard()
    {
        return view('dashboard.eleve');
    }

    private function enseignantDashboard()
    {
        return view('dashboard.enseignant');
    }

    private function defaultDashboard()
    {
        return view('dashboard.default');
    }
}
