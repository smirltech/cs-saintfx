{{-- Add Responsable --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-responsable-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Responsable</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="addThisResponsable">
                    <div class="row">
                        <div class="form-group col-md-9 col-sm-12">
                            <label for="">Nom</label>
                            <input placeholder="Saisir le nom du responsable" type="text"
                                   wire:model="responsable_nom"
                                   class="form-control" required>
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label for="">Sexe</label>
                            <select wire:model="responsable_sexe"
                                    class="form-control">
                                @foreach (\App\Enum\Sexe::cases() as $es )
                                    <option value="{{ strtoupper($es->value)}}">{{ $es->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">Téléphone</label>
                            <input placeholder="Saisir le numéro de téléphone" type="tel"
                                   wire:model="responsable_telephone"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">E-mail</label>
                            <input placeholder="Saisir l'adresse e-mail" type="text"
                                   wire:model="responsable_email"
                                   class="form-control">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="">Adresse </label>
                        <textarea placeholder="Saisir l'adresse du domicile"
                                  wire:model="responsable_adresse"
                                  rows="1"
                                  class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button form="f1" type="submit" class="btn btn-primary">Soumettre</button>
            </div>
        </div>

    </div>

</div>

{{-- edit Responsable --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="edit-responsable-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Responsable</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                <form id="f2" wire:submit.prevent="submitResponsable">
                    <div class="row">
                        <div class="form-group col-md-9 col-sm-12">
                            <label for="">Nom</label>
                            <input placeholder="Saisir le nom du responsable" type="text"
                                   wire:model="nom"
                                   class="form-control" required>
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label for="">Sexe</label>
                            <select wire:model="sexe"
                                    class="form-control">
                                @foreach (\App\Enum\Sexe::cases() as $es )
                                    <option value="{{ strtoupper($es->value)}}">{{ $es->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">Téléphone</label>
                            <input placeholder="Saisir le numéro de téléphone" type="tel"
                                   wire:model="telephone"
                                   class="form-control">
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">E-mail</label>
                            <input placeholder="Saisir l'adresse e-mail" type="text"
                                   wire:model="email"
                                   class="form-control">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="">Adresse </label>
                        <textarea placeholder="Saisir l'adresse du domicile"
                                  wire:model="adresse"
                                  rows="1"
                                  class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button form="f2" type="submit" class="btn btn-primary">Soumettre</button>
            </div>
        </div>

    </div>

</div>

