{{-- Edit Relation --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="edit-relation-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Relation</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="editRelation">

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="">Relation</label>
                            <select wire:model="responsable_relation"
                                    class="form-control">
                                @foreach (\App\Enum\ResponsableRelation::cases() as $es )
                                    <option value="{{$es->value}}">{{ $es->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button form="f1" type="submit" class="btn btn-warning">Soumettre</button>
            </div>
        </div>

    </div>

</div>

