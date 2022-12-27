<x-adminlte-modal wire:ignore.self id="update-presence" icon="fa fa-cubes"
                  title="Modifier État de Présence">
    <x-validation-errors class="mb-4" :errors="$errors"/>
    <form id="f2a" wire:submit.prevent="updatePresence">
        <div class="row">
            <div class="form-group col-md-12 col-sm-12">
                <label for="">État </label>
                <x-form-select wire:model="presence.status"
                               class="form-control">
                    @foreach (\App\Enums\PresenceStatus::cases() as $es )
                            <option value="{{$es->name}}">{{$es->label()}}</option>
                    @endforeach
                </x-form-select>

            </div>
            <div class="form-group col-md-12 col-sm-12">
                <x-form-input
                    type="text"
                    label="Observation"
                    wire:model="presence.observation">
                </x-form-input>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <button form="f2a" type="submit" class="btn btn-primary">Modifier</button>
    </x-slot>
</x-adminlte-modal>

<x-adminlte-modal wire:ignore.self id="delete-presence" icon="fa fa-cubes"
                  title="Supprimer la Présence">
    <x-validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer cette présence ?</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deletePresence" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
