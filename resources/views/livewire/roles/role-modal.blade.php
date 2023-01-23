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
                            required
                            :placeholder="false"
                            multiple
                            wire:model="new_permissions">
                            @foreach($permissions as $permission)
                                <option value="{{$permission->id}}">{{$permission->name}}</option>
                            @endforeach
                        </x-form::select>
                        <div class="text-green">
                            {{ count($role->permissions) }} {{ Str::plural('permission', count($role->permissions))}}
                            | {{$role->display_permissions}}
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <x-form::button type="submit" class="btn btn-primary">Soumettre</x-form::button>
            </div>
        </div>
    </form>
</div>
