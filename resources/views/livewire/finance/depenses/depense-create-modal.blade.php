<x-modals::modal-form>
    <div>
        <x-form::validation-errors class="mb-4" :errors="$errors"/>
        <form id="f1" wire:submit.prevent="addDepense">
            <div class="row">
                <div class="form-group col-md-4 col-sm-12">
                    <label for="">Type</label>
                    <x-form::select
                        wire:model="type.id"
                        class="form-control">
                        <option value=null>Choisir type...</option>
                        @foreach ($types as $es )
                            <option value="{{$es->id}}">{{ $es->nom }}</option>
                        @endforeach
                    </x-form::select>
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for="">Montant <i class="text-red">*</i></label>
                    <input type="number" wire:model="montant"
                           class="form-control @error('montant') is-invalid @enderror">
                    @error('montant')
                    <span class="text-red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for="">Référence</label>
                    <input type="text" wire:model="reference" class="form-control">

                </div>
            </div>
            <div class="form-group col-sm-12">
                <label for="">Note</label>
                <textarea rows="2" wire:model="note" class="form-control"></textarea>

            </div>
        </form>
    </div>
</x-modals::modal-form>
