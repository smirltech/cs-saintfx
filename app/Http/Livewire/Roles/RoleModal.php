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

    // rules function

    public function mount(Role $role): void
    {
        $this->role = $role;
        $this->permissions = Permission::all(['id', 'name']);
    }

    public function render(): View|Factory|Application
    {
        return view('livewire.roles.role-modal');
    }

    public function save(): void
    {
        $this->validate();
        $this->role->save();
        if (count($this->new_permissions) > 0) {
            $this->role->syncPermissions($this->new_permissions);
        }
        $this->emit('refreshRoles');
        $this->emit('hideModal');
    }
    

    public function delete(): void
    {
        $this->role->delete();
        $this->emit('refreshRoles');
        $this->emit('hideModal');
    }

    // delete

    protected function rules(): array
    {
        return [
            'role.name' => 'required|unique:roles,name,' . $this->role->id,
            'new_permissions' => 'nullable|array',
            'role.description' => 'nullable|string|max:255',
        ];
    }


}
