{{--add etiquette--}}
<x-adminlte-modal wire:ignore.self id="add-etiquette-modal" icon="fa fa-tag"
                  title="Ajout de Étiquette">
    <x-validation-errors class="mb-4" :errors="$errors"/>
    <form id="f1a" wire:submit.prevent="addEtiquette">
        <div class="row">

            <div class="form-group col-md-12 col-sm-12">
                <x-form-input
                    type="text"
                    label="Nom"
                    wire:model="etiquette.nom"
                    :is-valid="$errors->has('etiquette.nom')?false:null"
                    :error="$errors->first('etiquette.nom')">
                </x-form-input>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="f1a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

{{--update etiquette--}}
<x-adminlte-modal wire:ignore.self id="update-etiquette-modal" icon="fa fa-tag"
                  title="Modification d'Étiquette">
    <x-validation-errors class="mb-4" :errors="$errors"/>
    <form id="f2a" wire:submit.prevent="updateEtiquette">
        <div class="row">

            <div class="form-group col-md-12 col-sm-12">
                <x-form-input
                    type="text"
                    label="Nom"
                    wire:model="etiquette.nom"
                    :is-valid="$errors->has('etiquette.nom')?false:null"
                    :error="$errors->first('etiquette.nom')">
                </x-form-input>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="f2a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

{{--delete etiquette--}}
<x-adminlte-modal wire:ignore.self id="delete-etiquette-modal" icon="fa fa-tag"
                  title="Suppression d'Étiquette">
    <x-validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer cette étiquette</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteEtiquette" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
