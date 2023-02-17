{{-- Add Filiere --}}
@php use App\Enums\ClasseGrade; @endphp
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-filiere-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Filière</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="addFiliere">

                    <div class="row">
                        <div class="form-group col-10">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input type="text" wire:model="nom"
                                   class="form-control  @error('nom') is-invalid @enderror">
                            @error('nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-2">
                            <label for="">Code <i class="text-red">*</i></label>
                            <input type="text" wire:model="code"
                                   class="form-control  @error('code') is-invalid @enderror">
                            @error('code')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Section <i class="text-red">*</i></label>
                            <x-form::select wire:model="section_id" wire:change="changeSection"
                                            class="form-control  @error('section_id') is-invalid @enderror">
                                <option value="">Choisir section</option>
                                @foreach ($sections as $section )
                                    <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                @endforeach
                                @error('section_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </x-form::select>
                        </div>
                        <div class="form-group col-6">
                            <label for="">Option <i class="text-red">*</i></label>
                            <x-form::select wire:model="option_id"
                                            class="form-control  @error('option_id') is-invalid @enderror">
                                <option value="">Choisir option</option>
                                @foreach ($options as $option )
                                    <option value="{{ $option->id }}">{{ $option->nom }}</option>
                                @endforeach

                            </x-form::select>
                            @error('option_id')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea wire:model="description" rows="5" class="form-control"></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f1" type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>

    </div>

</div>

{{-- EditModal Filiere --}}
<div wire:ignore.self class="modal fade" tabindex="2" id="edit-filiere-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Filière</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f2" wire:submit.prevent="updateFiliere">
                    <div class="row">
                        <div class="form-group col-9">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input type="text" wire:model="nom"
                                   class="form-control  @error('nom') is-invalid @enderror">
                            @error('nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-3">
                            <label for="">Code <i class="text-red">*</i></label>
                            <input type="text" wire:model="code"
                                   class="form-control  @error('code') is-invalid @enderror">
                            @error('code')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Section <i class="text-red">*</i></label>
                            <x-form::select wire:model="section_id" wire:change="changeSection"
                                            class="form-control  @error('section_id') is-invalid @enderror">
                                <option value="">Choisir section</option>
                                @foreach ($sections as $section )
                                    <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                @endforeach
                                @error('section_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </x-form::select>
                        </div>
                        <div class="form-group col-6">
                            <label for="">Option <i class="text-red">*</i></label>
                            <x-form::select wire:model="option_id"
                                            class="form-control  @error('option_id') is-invalid @enderror">
                                <option value="">Choisir option</option>
                                @foreach ($options as $option )
                                    <option value="{{ $option->id }}">{{ $option->nom }}</option>
                                @endforeach

                            </x-form::select>
                            @error('option_id')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea wire:model="description" rows="5" class="form-control"></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f2" type="updateFiliere" class="btn btn-primary">Modifier</button>
            </div>
        </div>

    </div>

</div>

{{-- Delete Filiere --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="delete-filiere-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Suppression de filière</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette filière ?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button wire:click="deleteFiliere" class="btn btn-primary">Supprimer</button>
            </div>
        </div>

    </div>

</div>


{{-- AUTRES --}}

{{-- Add Classe --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-classe-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Classe</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f4" wire:submit.prevent="addClasse">
                    <div class="row">
                        <div class="form-group col">
                            <label for="">Grade <i class="text-red">*</i></label>
                            <x-form::select wire:change="setCode" wire:model="classe_grade"
                                            class="form-control  @error('classe_grade') is-invalid @enderror">
                                <option value="">Choisir grade</option>
                                @foreach (ClasseGrade::cases() as $grade )
                                    <option value="{{ $grade->value}}">{{ $grade->label() }}</option>
                                @endforeach
                            </x-form::select>
                            @error('classe_grade')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col">
                            <label for="">Code <i class="text-red">*</i></label>
                            <input type="text" readonly wire:model="classe_code"
                                   class="form-control  @error('classe_code') is-invalid @enderror">
                            @error('classe_code')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f4" type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>

    </div>

</div>

