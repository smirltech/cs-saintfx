<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class IndexComponent extends Component
{

    public Collection $roles;

    protected $listeners = ['refreshRoles' => '$refresh'];

    public function mount(): void
    {
        $this->roles = Role::all();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.roles.index-component')->with([
            'title' => 'Roles',
        ]);
    }
}
