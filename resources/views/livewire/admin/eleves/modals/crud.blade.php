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

{{-- Add Inscription --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-inscription-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reinscription</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                <form id="f2" wire:submit.prevent="addInscription">

                    {{-- Choix de classe --}}
                    <div>
                        <div class="row">
                            <div class="form-group col-3">
                                <label for="">Section <i class="text-red">*</i></label>
                                <select wire:model="inscription2_section_id" wire:change="changeSection"
                                        class="form-control  @error('section_id') is-invalid @enderror">
                                    <option value="">Choisir section</option>
                                    @foreach ($sections as $section )
                                        <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                    @endforeach
                                </select>
                                @error('section_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-3">
                                <label for="">Option</label>
                                <select wire:model="inscription2_option_id" wire:change="changeOption" class="form-control">
                                    <option value="">Choisir option</option>
                                    @foreach ($options as $option )
                                        <option value="{{ $option->id }}">{{ $option->nom }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group col-3">
                                <label for="">Filière</label>
                                <select wire:model="inscription2_filiere_id"
                                        wire:change="changeFiliere" class="form-control">
                                    <option value="">Choisir filière</option>
                                    @foreach ($filieres as $filiere )
                                        <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label for="">Classe <i class="text-red">*</i></label>
                                <select wire:model="inscription2_classe_id"
                                        class="form-control">
                                    <option value="">Choisir classe</option>
                                    @foreach ($classes as $classe )
                                        <option value="{{ $classe->id }}">{{ $classe->code }}</option>
                                    @endforeach
                                </select>
                                @error('classe_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="">Categorie <i class="text-red">*</i></label>
                                <select wire:model="inscription2_categorie"
                                        class="form-control  @error('inscription2_categorie') is-invalid @enderror">
                                    <option value="" disabled>Choisir categorie...</option>
                                    @foreach (\App\Enum\InscriptionCategorie::cases() as $es )
                                        <option value="{{$es->value}}">{{ $es->label() }}</option>
                                    @endforeach
                                    @error('inscription2_categorie')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="">Montant</label>
                                <input placeholder="Saisir frais d'inscription" type="number" wire:model="inscription2_montant"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    {{-- ./Choix de classe --}}
                </form>
            </div>
            <div class="modal-footer justify-content-between">
{{--                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>--}}
                <button form="f2" type="submit" class="btn btn-warning">Soumettre</button>
            </div>
        </div>

    </div>

</div>

{{-- Edit Inscription --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="edit-inscription-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Le choix de classe</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                <form id="f3" wire:submit.prevent="editInscription">

                    {{-- Choix de classe --}}
                    <div>
                        <div class="row">
                            <div class="form-group col-3">
                                <label for="">Section <i class="text-red">*</i></label>
                                <select wire:model="inscription2_section_id" wire:change="changeSection"
                                        class="form-control  @error('section_id') is-invalid @enderror">
                                    <option value="">Choisir section</option>
                                    @foreach ($sections as $section )
                                        <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                    @endforeach
                                </select>
                                @error('section_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-3">
                                <label for="">Option</label>
                                <select wire:model="inscription2_option_id" wire:change="changeOption" class="form-control">
                                    <option value="">Choisir option</option>
                                    @foreach ($options as $option )
                                        <option value="{{ $option->id }}">{{ $option->nom }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group col-3">
                                <label for="">Filière</label>
                                <select wire:model="inscription2_filiere_id"
                                        wire:change="changeFiliere" class="form-control">
                                    <option value="">Choisir filière</option>
                                    @foreach ($filieres as $filiere )
                                        <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label for="">Classe <i class="text-red">*</i></label>
                                <select wire:model="inscription2_classe_id"
                                        class="form-control">
                                    <option value="">Choisir classe</option>
                                    @foreach ($classes as $classe )
                                        <option value="{{ $classe->id }}">{{ $classe->code }}</option>
                                    @endforeach
                                </select>
                                @error('classe_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="">Categorie <i class="text-red">*</i></label>
                                <select wire:model="inscription2_categorie"
                                        class="form-control  @error('inscription2_categorie') is-invalid @enderror">
                                    <option value="" disabled>Choisir categorie...</option>
                                    @foreach (\App\Enum\InscriptionCategorie::cases() as $es )
                                        <option value="{{ strtoupper($es->value)}}">{{ $es->label() }}</option>
                                    @endforeach
                                    @error('inscription2_categorie')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="">Montant</label>
                                <input placeholder="Saisir frais d'inscription" type="number" wire:model="inscription2_montant"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    {{-- ./Choix de classe --}}
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                {{--                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>--}}
                <button wire:click="deleteInscription" type="button" class="btn btn-danger" data-dismiss="modal">Supprimer</button>
                <button form="f3" type="submit" class="btn btn-warning">Soumettre</button>
            </div>
        </div>

    </div>

</div>


