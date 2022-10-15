
<div class="">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-section-modal">
                                    <span
                                        class="fa fa-plus"></span></button>

    <div wire:ignore.self class="modal fade" id="add-section-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter Section</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <x-validation-errors class="mb-4" :errors="$errors"/>
                    <form id="f1" wire:submit.prevent="submit">
                        <div class="row">
                            <div class="form-group col-10">
                                <label for="">Nom <i class="text-red">*</i></label>
                                <input type="text" wire:keyup.debounce="genCode" wire:model="nom" class="form-control @error('nom') is-invalid @enderror">
                                @error('nom')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-2">
                                <label for="">Code <i class="text-red">*</i></label>
                                <input readonly type="text" wire:model="code" class="form-control @error('code') is-invalid @enderror">
                                @error('code')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button form="f1" type="submit" class="btn btn-primary">Soumettre</button>
                </div>
            </div>

        </div>

    </div>

</div>
