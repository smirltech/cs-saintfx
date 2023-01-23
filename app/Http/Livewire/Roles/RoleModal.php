<?php

namespace App\Http\Livewire\Roles;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class RoleModal extends Component
{
    public Role $role;
    public Collection $permissions;
    public array $new_permissions = [];

    protected $rules = [
        'role.name' => 'required|unique:roles,name',
        'new_permissions' => 'required|array',
        'role.description' => 'nullable|string|max:255',
    ];

    public function mount(Role $role): void
    {
        $this->role = $role;
        $this->permissions = Permission::all(['id', 'name']);
    }

    public function render(): View|Factory|Application
    {
        return view('livewire.roles.role-modal');
    }

    // updated
    /*    public function updated($propertyName): void
        {
            $this->validateOnly($propertyName);
        }*/

    // save
    public function save(): void
    {
        $this->validate();
        $this->role->save();
        $this->role->permissions()->sync($this->new_permissions);
        $this->emit('refreshRoles');
        $this->emit('closeModal');
    }


}
