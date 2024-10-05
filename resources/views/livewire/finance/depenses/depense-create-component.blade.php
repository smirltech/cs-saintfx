<div class="content mt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-{{$depense->status()?->color}}">
                    <div class="card-header">
                        <h3 class="card-title">{{$depense->status()?->label}}</h3>
                    </div>
                    <div class="card-body">
                        <form id="f1" wire:submit.prevent="submit">
                            <div class="row">
                                <div class="form-group col-md-4">
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
                                    <x-form::input.numeric
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
                            @if(!$depense->isApprovedByCoordonnateur())
                                <x-form::button.primary icon="save" class="float-end" label="Enregistrer"/>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <form id="f1" wire:submit.prevent="submitAttachment">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <x-form::input.file
                                    label="Documents (Facture, Bon de commande, etc)"
                                    required
                                    :media="$depense->media"
                                    wire:model="depense_media">
                                    @foreach ($types as $es )
                                        <option value="{{$es->id}}">{{ $es->nom }}</option>
                                    @endforeach
                                </x-form::input.file>
                            </div>
                        </div>
                        @if($depense->exists)
                            <x-form::button.primary icon="upload" class="float-end" label="Soumettre"/>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
