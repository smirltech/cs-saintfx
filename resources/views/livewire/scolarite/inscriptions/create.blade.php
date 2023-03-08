@php use App\Enums\Sexe; @endphp
@php use App\Enums\EtatCivil;use App\Enums\InscriptionCategorie;use App\Enums\ResponsableRelation; @endphp
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Inscription de l'élève</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.inscriptions') }}">Inscriptions</a></li>
                <li class="breadcrumb-item active">Nouvelle Inscription</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.scolarite.inscriptions.modals.add_responsable')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">

                <div id="inscriptionPrint" class="card-body">
                    {{-- <x-form::validation-errors class="mb-4" :errors="$errors"/>--}}
                    @json($eleve)
                    @json($inscription)
                    @json($perception)
                    @json($responsableEleve)
                    <form wire:submit.prevent="submit">
                        {{-- Information Personnelle--}}
                        <div>
                            <h4 class="font-weight-bold"><u>Information Personnelle</u></h4>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <x-form::input
                                        required
                                        label="Nom complet"
                                        placeholder="Siasir le mom, postnom et prénom)" type="text"
                                        wire:model="eleve.nom"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <x-form::select
                                        label="Sexe"
                                        required
                                        wire:model="eleve.sexe">
                                        @foreach (Sexe::cases() as $es)
                                            <option value="{{$es->name}}">{{ $es->label() }}</option>
                                        @endforeach
                                    </x-form::select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <x-form::input
                                        label="Lieu de naissance"
                                        placeholder="Saisir la ville / village de naissance"
                                        wire:model="eleve.lieu_naissance"
                                    />

                                </div>
                                <div class="form-group col-md-4">
                                    <x-form::input
                                        label="Date de naissance"
                                        type="date" wire:model="eleve.date_naissance"
                                    />

                                </div>

                                <div class="form-group col-md-4">
                                    <label for=""></label>
                                    <x-form::input label="No. permanent (SERNI)"
                                                   placeholder="Saisir le numero permanent"
                                                   wire:model="eleve.numero_permanent"/>
                                </div>
                            </div>
                            <div>
                                <h6 class="font-weight-bold"><u>Informations sur les parents</u></h6>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <x-form::input
                                            label="Père"
                                            placeholder="Saisir le nom du père"
                                            wire:model="eleve.pere"
                                            class="form-control"/>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <x-form::input
                                            label="Mère"
                                            placeholder="Saisir le nom complet de la mère" type="text"
                                            wire:model="eleve.mere"
                                            class="form-control"/>
                                    </div>

                                </div>
                            </div>
                            <div>
                                <h6 class="font-weight-bold"><u>Informations de contacts</u></h6>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <x-form::input
                                            label="Téléphone"
                                            placeholder="Saisir le numéro de téléphone"
                                            type="tel"
                                            wire:model="eleve.telephone"
                                            class="form-control"/>
                                    </div>
                                    <div class="form-group col-md-4 ">
                                        <x-form::input
                                            label="E-mail"
                                            placeholder="Saisir l'adresse e-mail"
                                            type="text"
                                            wire:model="eleve.email"
                                            class="form-control"/>
                                    </div>
                                    <div class="form-group col-md-4 ">
                                        <x-form::input
                                            label="Adresse"
                                            placeholder="Saisir l'adresse du domicile"
                                            wire:model="eleve.adresse"
                                            rows="1"
                                            class="form-control"/>
                                    </div>

                                </div>
                            </div>


                        </div>

                        <hr>

                        <h4 class="font-weight-bold"><u>Information sur le responsable / tuteur</u></h4>
                        <div class="form-group">
                            <div class="row mt-2 mb-2">
                                <div class="form-group   @if($responsableEleve->responsable_id)col-md-6 @endif">
                                    <x-form::select
                                        label="Responsable"
                                        wire:change.debounce="changeSelectedResponsable"
                                        wire:model="responsableEleve.responsable_id">
                                        @foreach ($responsables as $respo)
                                            <option value="{{$respo->id}}">{{ $respo->detail }}</option>
                                        @endforeach
                                    </x-form::select>
                                </div>
                                @if($responsableEleve->responsable_id)
                                    <div class="form-group col-md-6">
                                        <x-form::select
                                            label="Relation"
                                            wire:model="responsableEleve.relation">
                                            @foreach (ResponsableRelation::cases() as $es )
                                                <option value="{{$es->value}}">{{ $es->label() }}</option>
                                            @endforeach
                                        </x-form::select>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr>

                        <div>
                            <h4 class="font-weight-bold"><u>Choix de classe</u></h4>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <x-form::select
                                        wire:model="inscription.classe_id"
                                        label="Classe">
                                        @foreach ($classes as $classe )
                                            <option value="{{ $classe->id }}">{{ $classe->code }}</option>
                                        @endforeach
                                    </x-form::select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Categorie <i class="text-red">*</i></label>
                                <x-form::select

                                    wire:model="inscription.categorie">
                                    <option value="" disabled>Choisir categorie...</option>
                                    @foreach (InscriptionCategorie::cases() as $es )
                                        <option value="{{$es->name}}">{{ $es->label() }}</option>
                                    @endforeach
                                    @error('categorie')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </x-form::select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Frais d'inscription</label>
                                <input readonly placeholder="Saisir frais d'inscription" type="number"
                                       wire:model="perception.fee_montant"
                                       class="form-control">
                            </div>
                            @if($perception->fee_id)
                                <div class="form-group col-md-3">
                                    <label for="">Payé</label>
                                    <div class="form-check">
                                        <input disabled wire:model="has_paid" type="checkbox"
                                               class=" form-check-input"
                                               id="exampleCheck2">
                                        <label class="form-check-label" for="exampleCheck2">Cocher si frais
                                            d'inscription payé</label>
                                    </div>
                                </div>
                            @endif
                            @if($has_paid && $perception->fee_id)
                                <div class="form-group col-md-3 ">
                                    <label for="">Payé par</label>
                                    <input placeholder="Saisir nom de celui qui paie" type="text"
                                           wire:model="paid_by"
                                           class="form-control">
                                </div>
                            @endif

                        </div>

                        {{-- ./Choix de classe --}}
                        <x-form::button type="submit" class="btn btn-primary">Soumettre</x-form::button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
