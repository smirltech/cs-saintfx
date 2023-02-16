<x-form::modal>
    <x-slot:title>
        <h5 class="modal-title">Ajout d'ouvrage</h5>
    </x-slot:title>
    @json($ouvrage)
    <div class="row">
        <div class="form-group col-md-12 col-sm-12">
            <x-form::input
                type="text"
                label="Titre"
                wire:model="ouvrage.titre">
            </x-form::input>
        </div>

        <div class="form-group col-md-12 col-sm-12">
            <x-form::input
                type="text"
                label="Sous Titre"
                wire:model="ouvrage.sous_titre">
            </x-form::input>
        </div>
        <div class="form-group col-md-6 col-sm-12">
            <label for="">Groupe</label>
            <x-form::select
                label="Choisir groupe"
                wire:model="ouvrage.ouvrage_category_id">
                @foreach ($categories as $es )
                    <option value="{{$es->id}}">{{ $es->nom }}</option>
                @endforeach
            </x-form::select>
        </div>
        <div class="form-group col-md-6 col-sm-12">
            <x-form::input
                type="date"
                label="Date"
                placeholder="Date d'édition">
            </x-form::input>
        </div>

        <div class="form-group col-md-4 col-sm-12">
            <x-form::input
                label="Edition"
                placeholder="Tome 2"
                wire:model="ouvrage.edition">
            </x-form::input>
        </div>
        <div class="form-group col-md-4 col-sm-12">
            <x-form::input
                label="Editeur"
                placeholder="Maison d'édition"
                wire:model="ouvrage.editeur">
            </x-form::input>
        </div>
        <div class="form-group col-md-4 col-sm-12">
            <x-form::input
                label="Lieu"
                placeholder="Ville d'édition"
                wire:model="ouvrage.lieu">
            </x-form::input>
        </div>

        <div class="form-group col-md-12 col-sm-12">
            <x-form::ckeditor
                label="Description"
                wire:model="ouvrage.resume"/>

        </div>
        <div class="form-group col-md-12 col-sm-12">
            <x-form::input
                label="Lien URL"
                placeholder="Lien url du site"
                wire:model="ouvrage.url">
            </x-form::input>
        </div>
        <div class="form-group col-md-12 col-sm-12">
            <x-form::input-pdf
                label="Fichier PDF"
                :media="$ouvrage->media"
                wire:model="ouvrage_pdf">
            </x-form::input-pdf>
        </div>

    </div>
    <x-slot name="footer">
        <div class="d-flex">
            <x-form::button-primary type="submit" class="mr-3">
                Soumettre
            </x-form::button-primary>
        </div>
    </x-slot>
</x-form::modal>

