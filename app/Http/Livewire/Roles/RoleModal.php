<?php

namespace App\Http\Livewire\Roles;

use App\Http\Livewire\BaseComponent;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class RoleModal extends BaseComponent
{
    public Role $role;
    public Collection $permissions;
    public array $new_permissions = [];

    // rules function

    /**
     * @throws AuthorizationException
     */
    public function mount(Role $role): void
    {
        if ($role->id) {
            $this->authorize('update', $role);
        } else {
            $this->authorize('create', Role::class);
        }

        $this->role = $role;
        $this->permissions = Permission::all(['id', 'name']);
        $this->new_permissions = $role->permissions->pluck('id')->toArray();
    }

    public function render(): View|Factory|Application
    {
        return view('livewire.roles.role-modal');
    }

    /**
     * @throws AuthorizationException
     */
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

    public function getPermissionNames(): array
    {
        // get permission names from $new_permissions array of ids
        $permission_names = [];
        foreach ($this->new_permissions as $permission_id) {
            $permission_names[] = $this->permissions->find($permission_id)->name;
        }
        return $permission_names;
    }

    // get permission names

    protected function rules(): array
    {
        return [
            'role.name' => 'required|unique:roles,name,' . $this->role->id,
            'new_permissions' => 'nullable|array',
            'role.description' => 'nullable|string|max:255',
        ];
    }


}
