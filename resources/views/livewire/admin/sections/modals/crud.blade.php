
{{-- Show Section --}}
{{--
<div wire:ignore.self class="modal fade" tabindex="-1" id="show-section-modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Section : {{$section->nom??''}}</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4 class="m-0">Détail sur la section</h4>
                        </div>
                        <div class="card-tools">
                            @if($section != null)
                                <button type="button"
                                        title="Modifier" class="btn btn-info  ml-2" data-toggle="modal"
                                        data-target="#edit-section-modal">
                                    <span class="fa fa-pen"></span>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <label>Nom : </label>
                                {{ $section->nom??'' }}
                            </div>
                            <div class="col">
                                <label>Code : </label>
                                {{ $section->code??'' }}
                            </div>

                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4 class="m-0">Options de la section</h4>
                        </div>
                        <div class="card-tools d-flex my-auto">
                            @if($section != null)
                               --}}
{{-- <a href="{{ route('admin.options.create',["section_id"=>$section->id]) }}" title="ajouter"
                                   class="btn btn-primary mr-2"><span
                                        class="fa fa-plus"></span></a>--}}{{--

                                <button type="button"
                                        class="btn btn-primary  ml-2" data-toggle="modal"
                                        data-target="#add-option-modal"><span
                                        class="fa fa-plus"></span></button>
                            @endif
                        </div>
                    </div>

                    <div class="card-body p-0 table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>OPTION</th>
                                <th style="width: 100px">CODE</th>

                                <th style="width: 100px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($section != null)
                                @foreach ($section->options as $option)
                                    <tr>
                                        <td><a href="/admin/options/{{ $option->id }}">{{ $option->nom }}</a></td>

                                        <td>{{ $option->code }}</td>

                                        <td>
                                            <div class="d-flex float-right">
                                                <a href="/admin/options/{{ $option->id }}" title="Voir"
                                                   class="btn btn-warning">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                --}}
{{--  <a href="/filiere-edit/{{ $filiere->id }}" title="modifier" class="btn btn-info  ml-2">
                                                     <i class="fas fa-pen"></i>
                                                 </a>

                                                 <button wire:click="deleteFiliere({{ $filiere->id }})" title="supprimer" class="btn btn-danger ml-2">
                                                     <i class="fas fa-trash"></i>
                                                 </button> --}}{{--

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
--}}


{{-- Add Section --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-section-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Section</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="addSection">
                    <div class="row">
                        <div class="form-group col-md-9 col-sm-6">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input autotext type="text" wire:keyup.debounce="genCode" wire:model="nom" class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3 col-sm-6">
                            <label for="">Code <i class="text-red">*</i></label>
                            <input readonly type="text" wire:model="code" class="form-control @error('code') is-invalid @enderror">
                           {{-- @error('code')
                            <span class="text-red">{{ $message }}</span>
                            @enderror--}}
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button form="f1" type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>

    </div>

</div>

{{-- Edit Section --}}
<div wire:ignore.self class="modal fade" tabindex="2" id="edit-section-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Section</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                <form id="f2" wire:submit.prevent="updateSection">
                    <div class="row">
                        <div class="form-group col-md-9 col-sm-6">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input autofocus type="text" wire:keyup.debounce="genCode" wire:model="nom"
                                   class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3 col-sm-6">
                            <label for="">Code <i class="text-red">*</i></label>
                            <input readonly type="text" wire:model="code"
                                   class="form-control @error('code') is-invalid @enderror">
                            {{--@error('code')
                            <span class="text-red">{{ $message }}</span>
                            @enderror--}}
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button form="f2" type="updateSection" class="btn btn-primary">Modifier</button>
            </div>
        </div>

    </div>

</div>

{{-- Delete Section --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="delete-section-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Suppression de Section</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <p>Êtes-vous sûr de vouloir supprimer cette section ?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button wire:click="deleteSection" class="btn btn-primary">Supprimer</button>
            </div>
        </div>

    </div>

</div>


{{--------------------------------------------------------}}

{{-- Add Option --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-option-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Option</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                <form id="f4" wire:submit.prevent="addOption">

                    <div class="row">
                        <div class="form-group col-9">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input wire:keyup.debounce="genCode" type="text" wire:model="option_nom" class="form-control @error('option_nom') is-invalid @enderror">
                            @error('option_nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-3">
                            <label for="">Code <i class="text-red">*</i></label>
                            <input type="text" wire:model="option_code" class="form-control @error('option_code') is-invalid @enderror">
                            @error('option_code')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button form="f4" type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>

    </div>

</div>

