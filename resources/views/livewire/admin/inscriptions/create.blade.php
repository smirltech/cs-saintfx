@php use App\Enum\Sexe;use App\Enum\EtudiantSexe; @endphp
@php use App\Enum\EtatCivil;use App\Enum\InscriptionCategorie;use App\Enum\ResponsableRelation; @endphp
@section('title')
    {{Str::upper('cenk')}} - inscrire élève
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Inscription de l'élève</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.inscriptions') }}">Inscriptions</a></li>
                <li class="breadcrumb-item active">Nouvelle Inscription</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.admin.inscriptions.modals.add_responsable')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                    <x-validation-errors class="mb-4" :errors="$errors"/>
                    <form wire:submit.prevent="submit">
                        {{-- Information Personnelle--}}
                        <div>
                            <h4 class="font-weight-bold"><u>Information Personnelle</u></h4>
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="">Nom <i class="text-red">*</i></label>
                                    <input placeholder="Saisir le nom" type="text" wire:model="nom"
                                           class="form-control  @error('nom') is-invalid @enderror">
                                    @error('nom')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="">Postnom <i class="text-red">*</i></label>
                                    <input placeholder="Saisir le postnom" type="text" wire:model="postnom"
                                           class="form-control  @error('postnom') is-invalid @enderror">
                                    @error('postnom')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="">Prenom</label>
                                    <input placeholder="Saisir le prenom" type="text" wire:model="prenom"
                                           class="form-control">

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                    <label for="">Lieu de naissance</label>
                                    <input placeholder="Saisir la ville / village de naissance" type="text"
                                           wire:model="lieu_naissance"
                                           class="form-control">

                                </div>
                                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                    <label for="">Date de naissance</label>
                                    <input type="date" wire:model="date_naissance"
                                           class="form-control">

                                </div>
                                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                    <label for="">Sexe <i class="text-red">*</i></label>
                                    <select wire:model="sexe" class="form-control  @error('sexe') is-invalid @enderror">
                                        <option value="" disabled>Choisir sexe...</option>
                                        @foreach (Sexe::cases() as $es )
                                            <option value="{{ strtoupper($es->value)}}">{{ $es->label() }}</option>
                                        @endforeach
                                        @error('sexe')
                                        <span class="text-red">{{ $message }}</span>
                                        @enderror
                                    </select>
                                </div>
                                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                    <label for="">Matricule</label>
                                    <input placeholder="Saisir le matricule" type="text" wire:model="matricule"
                                           class="form-control">
                                </div>
                            </div>
                            <h6 class="font-weight-bold"><u>Informations de contacts</u></h6>
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="">Téléphone</label>
                                    <input placeholder="Saisir le numéro de téléphone" type="tel" wire:model="telephone"
                                           class="form-control">
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="">E-mail</label>
                                    <input placeholder="Saisir l'adresse e-mail" type="text" wire:model="email"
                                           class="form-control">
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="">Adresse </label>
                                    <textarea placeholder="Saisir l'adresse du domicile" wire:model="adresse" rows="1"
                                              class="form-control"></textarea>
                                </div>

                            </div>
                        </div>
                        {{-- ./Information Personnelle--}}
                        <hr>
                        {{-- Information sur le responsable--}}
                        <div>
                            <h4 class="font-weight-bold"><u>Information sur le responsable / tuteur</u></h4>
                            <div>
                                <strong>Si le responsable n'est pas encore dans le système </strong><button type="button" wire:click="setChooseResponsable()" class="btn btn-primary" data-toggle="modal"
                                        @if(!$chooseResponsable) data-target="#add-responsable-modal" @endif>{{$chooseResponsable?'Choisir':'Ajouter'}} Responsable</button>

                            </div>
                            @if(!$chooseResponsable)

                            <div>
                                <div class="mt-1"> <strong>Mais, si le responsable est pas déjà dans le système, recherchez-le </strong></div>
                                @include('livewire.admin.inscriptions.blocks.responsables_search_block')
                            </div>
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
                                <div class="form-group col-3">
                                    <label for="">Section <i class="text-red">*</i></label>
                                    <select wire:model="section_id" wire:change="changeSection"
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
                                    <select wire:model="option_id" wire:change="changeOption" class="form-control">
                                        <option value="">Choisir option</option>
                                        @foreach ($options as $option )
                                            <option value="{{ $option->id }}">{{ $option->nom }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group col-3">
                                    <label for="">Filière</label>
                                    <select wire:model="filiere_id"
                                            wire:change="changeFiliere" class="form-control">
                                        <option value="">Choisir filière</option>
                                        @foreach ($filieres as $filiere )
                                            <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-3">
                                    <label for="">Classe <i class="text-red">*</i></label>
                                    <select wire:model="classe_id"
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
                                    <select wire:model="categorie"
                                            class="form-control  @error('categorie') is-invalid @enderror">
                                        <option value="" disabled>Choisir categorie...</option>
                                        @foreach (InscriptionCategorie::cases() as $es )
                                            <option value="{{ strtoupper($es->value)}}">{{ $es->label() }}</option>
                                        @endforeach
                                        @error('categorie')
                                        <span class="text-red">{{ $message }}</span>
                                        @enderror
                                    </select>
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="">Montant</label>
                                    <input placeholder="Saisir frais d'inscription" type="number" wire:model="montant"
                                           class="form-control">
                                </div>
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
