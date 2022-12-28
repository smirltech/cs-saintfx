<x-adminlte-modal wire:ignore.self id="add-presence" icon="fa fa-people-group"
                  title="Présence {{\Carbon\Carbon::parse($current_date)->format('d-m-Y')}}">
    <x-validation-errors class="mb-4" :errors="$errors"/>
    <form id="f1a" wire:submit.prevent="addPresence">
        <div class="row">
            <div class="form-group col-md-12 col-sm-12">
                <label for="">Élève </label>
                <x-form-select wire:model="presence.inscription_id"
                               class="form-control">
                    @foreach ($nonInscriptions as $es )
                        <option value="{{$es->id}}">{{$es->nomComplet}}</option>
                    @endforeach
                </x-form-select>
            </div>
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
        <button form="f1a" type="submit" class="btn btn-primary">Confirmer</button>
    </x-slot>
</x-adminlte-modal>

