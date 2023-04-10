<div class="content mt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-3">
                    <x-form::validation-errors class="mb-4" :errors="$errors"/>
                    <form id="f1" wire:submit.prevent="submit">
                        <div class="row">
                            <div class="form-group col-md-4 col-sm-12">
                                <x-form::select
                                    label="Type de dépense"
                                    required
                                    wire:model="depense.depense_type_id">
                                    @foreach ($types as $es )
                                        <option value="{{$es->id}}">{{ $es->nom }}</option>
                                    @endforeach
                                </x-form::select>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <x-form::input-numeric
                                    label="Montant"
                                    type="number"
                                    required
                                    wire:model="depense.montant"/>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <x-form::input
                                    type="date"
                                    label="Date"
                                    wire:model="depense.date"
                                    class="form-control"/>

                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <x-form::ckeditor
                                label="Note"
                                rows="2"
                                wire:model="depense.note"/>
                        </div>
                        <x-form::button-primary icon="save" class="float-end" label="Enregistrer"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
