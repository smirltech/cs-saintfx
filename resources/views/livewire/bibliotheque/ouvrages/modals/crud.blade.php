{{--add category--}}
<x-adminlte-modal wire:ignore.self id="add-ouvrage-modal" icon="fa fa-book"
                  title="Ajout d'oubrage">
    <x-validation-errors class="mb-4" :errors="$errors"/>
    <form id="f1a" wire:submit.prevent="addOuvrage">
        {{--<div class="row">

            <div class="form-group col-md-12 col-sm-12">
                <x-form-input
                    type="text"
                    label="Nom"
                    wire:model="category.nom"
                    :is-valid="$errors->has('category.nom')?false:null"
                    :error="$errors->first('category.nom')">
                </x-form-input>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <label for="">Groupe</label>
                <select wire:model="category.ouvrage_category_id"
                        class="form-control">
                    <option value=null>Choisir groupe...</option>
                    @foreach ($categories as $es )
                        <option value="{{$es->id}}">{{ $es->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <label for="">Description</label>
                <textarea rows="2" wire:model="category.description" class="form-control"></textarea>

            </div>

        </div>--}}
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="f1a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

{{--update category--}}
<x-adminlte-modal wire:ignore.self id="update-oubrage-modal" icon="fa fa-tag"
                  title="Modification d'ouvrage">
    <x-validation-errors class="mb-4" :errors="$errors"/>
    <form id="f2a" wire:submit.prevent="updateOuvrage">

    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="f2a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

{{--delete category--}}
<x-adminlte-modal wire:ignore.self id="delete-ouvrage-modal" icon="fa fa-tag"
                  title="Suppression d'ouvrage">
    <x-validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer cet ouvrage ?</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteOuvrage" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
