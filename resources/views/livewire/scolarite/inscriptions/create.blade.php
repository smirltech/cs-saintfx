@php use App\Enums\Sexe; @endphp
@php use App\Enums\EtatCivil;use App\Enums\InscriptionCategorie;use App\Enums\ResponsableRelation; @endphp
@section('title')
    - inscrire élève
@endsection
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
    {{--  @include('livewire.finance.cards.recu')--}}
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">

                <div id="inscriptionPrint" class="card-body">
                    <x-form::validation-errors class="mb-4" :errors="$errors"/>
                    <form wire:submit.prevent="submit">
                        {{-- Information Personnelle--}}
                        <div>
                            <h4 class="font-weight-bold"><u>Information Personnelle</u></h4>
                            <div class="row">
                                <div class="form-group col-md-12 ">
                                    <label for="">Nom Complet (Nom  Postnom  Prénom) <i class="text-red">*</i></label>
                                    <input placeholder="Saisir le nom" type="text" wire:model="nom"
                                           class="form-control  @error('nom') is-invalid @enderror">
                                    @error('nom')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="">Lieu de naissance</label>
                                    <input placeholder="Saisir la ville / village de naissance" type="text"
                                           wire:model="lieu_naissance"
                                           class="form-control">

                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Date de naissance</label>
                                    <input type="date" wire:model="date_naissance"
                                           class="form-control">

                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Sexe <i class="text-red">*</i></label>
                                    <x-form::select wire:model="sexe">
                                        @foreach (Sexe::cases() as $es)
                                            <option value="{{$es->name}}">{{ $es->label() }}</option>
                                        @endforeach
                                    </x-form::select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">No. permanent</label>
                                    <input placeholder="Saisir le numero permanent" type="text"
                                           wire:model="numero_permanent"
                                           class="form-control">
                                </div>
                            </div>
                            <h6 class="font-weight-bold"><u>Informations de contacts</u></h6>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="">Téléphone</label>
                                    <input placeholder="Saisir le numéro de téléphone" type="tel" wire:model="telephone"
                                           class="form-control">
                                </div>
                                <div class="form-group col-md-4 ">
                                    <label for="">E-mail</label>
                                    <input placeholder="Saisir l'adresse e-mail" type="text" wire:model="email"
                                           class="form-control">
                                </div>
                                <div class="form-group col-md-4 ">
                                    <label for="">Adresse </label>
                                    <textarea placeholder="Saisir l'adresse du domicile" wire:model="adresse" rows="1"
                                              class="form-control"></textarea>
                                </div>

                            </div>

                            <h6 class="font-weight-bold"><u>Informations sur les parents</u></h6>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="">Père</label>
                                    <input placeholder="Saisir le nom complet du père" type="text" wire:model="pere"
                                           class="form-control">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">Mère</label>
                                    <input placeholder="Saisir le nom complet de la mère" type="text" wire:model="mere"
                                           class="form-control">
                                </div>

                            </div>
                        </div>
                        {{-- ./Information Personnelle--}}
                        <hr>
                        {{-- Information sur le responsable--}}
                        <div>
                            <h4 class="font-weight-bold"><u>Information sur le responsable / tuteur</u></h4>
                            @if(!$chooseResponsable)
                                @include('livewire.scolarite.inscriptions.blocks.responsables_search_block')
                            @endif
                        </div>
                        {{-- ./Information sur le responsable--}}
                        <hr>
                        {{-- Choix de classe --}}
                        <div>
                            <h4 class="font-weight-bold"><u>Choix de classe</u></h4>
                            <p>Procédez à l'inscription de ce candidat pour l'année scolaire <span
                                    class="text-red">{{$annee_courante->nom}}</span>, dans la classe que vous
                                sélectionnerez ci-dessous.
                                Pour choisir la classe, vous devez commencer par sélectionner la section, puis l'option,
                                ensuite la filière et finalement la classe.</p>
                            <p>Il y a des sections sans options ni filières, dans ce cas choisir seulement la section,
                                puis
                                la classe.</p>
                            <p>Il y a des options sans filières, dans ce cas choisir seulement la section, puis
                                l'option, et
                                enfin la classe.</p>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <x-form::select
                                        required
                                        label="Section"
                                        wire:model="section_id"
                                        wire:click="changeSection"
                                        placeholder="Choisir section"
                                    >
                                        @foreach ($sections as $section )
                                            <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                        @endforeach
                                    </x-form::select>
                                    @error('section_id')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <x-form::select
                                        label="Option"
                                        wire:model="option_id"
                                        placeholder="Choisir option"
                                        wire:change="changeOption">
                                        @foreach ($options as $option )
                                            <option value="{{ $option->id }}">{{ $option->nom }}</option>
                                        @endforeach
                                    </x-form::select>

                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Filière</label>
                                    <x-form::select wire:model="filiere_id"
                                                    wire:change="changeFiliere" class="form-control">
                                        <option value=null>Choisir filière</option>
                                        @foreach ($filieres as $filiere )
                                            <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                        @endforeach
                                    </x-form::select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Classe <i class="text-red">*</i></label>
                                    <x-form::select wire:change="changeClasse" wire:model="classe_id"
                                                    class="form-control">
                                        <option value=null>Choisir classe</option>
                                        @foreach ($classes as $classe )
                                            <option value="{{ $classe->id }}">{{ $classe->code }}</option>
                                        @endforeach
                                    </x-form::select>
                                    @error('classe_id')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3 ">
                                    <label for="">Categorie <i class="text-red">*</i></label>
                                    <x-form::select wire:model="categorie">
                                        <option value="" disabled>Choisir categorie...</option>
                                        @foreach (InscriptionCategorie::cases() as $es )
                                            <option value="{{$es->name}}">{{ $es->label() }}</option>
                                        @endforeach
                                        @error('categorie')
                                        <span class="text-red">{{ $message }}</span>
                                        @enderror
                                    </x-form::select>
                                </div>
                                <div class="form-group col-md-3 ">
                                    <label for="">Frais d'inscription</label>
                                    <input readonly placeholder="Saisir frais d'inscription" type="number"
                                           wire:model="fee_montant"
                                           class="form-control">
                                </div>
                                @if($fee_id)
                                    <div class="form-group col-md-3 ">
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
                                @if($has_paid && $fee_id)
                                    <div class="form-group col-md-3 ">
                                        <label for="">Payé par</label>
                                        <input placeholder="Saisir nom de celui qui paie" type="text"
                                               wire:model="paid_by"
                                               class="form-control">
                                    </div>
                                @endif

                            </div>
                        </div>
                        {{-- ./Choix de classe --}}
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
