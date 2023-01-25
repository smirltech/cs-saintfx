<?php

namespace App\Http\Livewire\Roles;

use App\Enums\RolePermission;
use App\Http\Livewire\BaseComponent;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class IndexComponent extends BaseComponent
{

    public Collection $roles;

    protected $listeners = ['refreshRoles' => '$refresh'];

    /**
     * @throws AuthorizationException
     */
    public function mount(): void
    {

        $this->authorize('viewAny', Role::class);
        $this->roles = Role::all();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.roles.index-component')->with([
            'title' => 'Roles',
        ]);
    }

    public function refreshPermissions(): void
    {
        foreach (RolePermission::cases() as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission->value]
            );
        }
    }
}
