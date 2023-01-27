<div class="modal-dialog">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form wire:submit.prevent="save">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <x-form::input
                            required
                            label="Nom"
                            placeholder="Nom du rôle"
                            wire:model="role.name"
                        />
                    </div>
                    <div class="form-group col-md-12">
                        <x-form::input
                            placeholder="Description du rôle"
                            label="Description"
                            wire:model="role.description"
                        />
                    </div>
                    <div class="form-group col-md-12">
                        <x-form::select
                            label="Permissions"
                            :placeholder="false"
                            multiple
                            wire:model="new_permissions">
                            @foreach($permissions as $permission)
                                <option value="{{$permission->id}}">{{$permission->displayName}}</option>
                            @endforeach
                        </x-form::select>
                        @if($role->id)
                            <div class="text-black mt-1">
                                {{ count($role->permissions) }} {{ Str::plural('permission', count($role->permissions))}}
                                | {{$role->display_permissions}}
                            </div>
                        @endif
                        <div class="text-green">
                            {{ count($new_permissions) }} {{ Str::plural('permission', count($new_permissions))}}
                            | {{implode(', ', $this->getPermissionNames())}}
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                @if($role->id AND $role->users->isEmpty())
                    <button type="button" class="btn btn-danger" wire:click="delete">Supprimer</button>
                @endif
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <x-form::button type="submit" class="btn btn-primary">Soumettre</x-form::button>
            </div>
        </div>
    </form>
</div>
