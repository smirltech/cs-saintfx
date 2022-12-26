{{-- Add Section --}}

@php use App\Enums\FraisType; @endphp
@php use App\Enums\FraisFrequence; @endphp
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-perception-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Imputer Frais</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="imputerFrais">
                    <div class="row">

                        <div class="form-group col-sm-12">
                            <label for="">Frais</label>
                            <select wire:change="feeSelected" wire:model="fee_id"
                                    class="form-control">
                                <option value="">Choisir frais... !</option>
                                @foreach ($frais as $fee )
                                    <option value="{{$fee->id}}">{{ $fee->nom }} [{{ $fee->type->label() }}]
                                        [{{ $fee->frequence->label() }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Montant Facturé <i class="text-red">*</i></label>
                            <input type="number" wire:model="montant"
                                   class="form-control @error('montant') is-invalid @enderror">
                            @error('montant')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Montant Payé</label>
                            <input type="number" wire:model="paid"
                                   class="form-control">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Payé par</label>
                            <input type="text" wire:model="paid_by"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="">Raison</label>
                        <select wire:model="custom_property"
                                class="form-control">
                            <option value="">Choisir raison... !</option>
                            @foreach ($raisons as $raison )
                                <option value="{{$raison}}">{{$raison}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f1" type="submit" class="btn btn-primary">Imputer</button>
            </div>
        </div>

    </div>

</div>

<div wire:ignore.self class="modal fade" tabindex="-1" id="pay-perception-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Imputer Frais</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1a" wire:submit.prevent="payPerception">
                    <div class="row">

                        <div class="form-group col-sm-12">
                            <label for="">Montant payé (max : {{$perception->montant??''}}) <i
                                    class="text-red">*</i></label>
                            <input type="number" max="{{$perception->montant??0}}" wire:model="paid"
                                   class="form-control @error('paid') is-invalid @enderror"
                                   placeholder="{{$perception->montant??''}}">
                            @error('paid')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Payé par</label>
                            <input type="text" wire:model="paid_by"
                                   class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f1a" type="submit" class="btn btn-primary">Imputer</button>
            </div>
        </div>

    </div>

</div>


{{-- Edit Section --}}
<div wire:ignore.self class="modal fade" tabindex="2" id="edit-frais-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Revenu</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                <form id="f2" wire:submit.prevent="updateFrais">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input type="text" wire:model="nom" class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">Montant <i class="text-red">*</i></label>
                            <input type="number" wire:model="montant"
                                   class="form-control @error('montant') is-invalid @enderror">
                            @error('montant')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">Type</label>
                            <select wire:model="type"
                                    class="form-control">
                                @foreach (FraisType::cases() as $es )
                                    <option value="{{$es->value}}">{{ $es->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">Fréquence</label>
                            <select wire:model="frequence"
                                    class="form-control">
                                @foreach (FraisFrequence::cases() as $es )
                                    <option value="{{$es->value}}">{{ $es->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="">Description</label>
                        <textarea rows="2" wire:model="description" class="form-control"></textarea>

                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f2" type="submit" class="btn btn-primary">Modifier</button>
            </div>
        </div>

    </div>

</div>

{{-- Delete Section --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="delete-frais-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Suppression de Frais</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer ce frais ?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button wire:click="deleteFrais" class="btn btn-primary">Supprimer</button>
            </div>
        </div>

    </div>

</div>
