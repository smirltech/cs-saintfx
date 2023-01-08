@php use Carbon\Carbon; @endphp
@section('title')
    - Ouvrage - {{$ouvrage->titre}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-university mr-1"></span>ouvrage</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('bibliotheque.ouvrages') }}">Ouvrages</a></li>
                <li class="breadcrumb-item active">{{$ouvrage->titre}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.bibliotheque.ouvrages.modals.crud')
    @include('livewire.bibliotheque.ouvrages.modals.auteur')
    @include('livewire.bibliotheque.ouvrages.modals.etiquette')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="m-0">{{$ouvrage->titre}}</h4>
                            </div>
                            <div class="card-tools">
                                <span
                                    title="Modifier" role="button" class="ml-2 mr-2" data-toggle="modal"
                                    data-target="#update-category-modal">
                                    <span class="fa fa-pen"></span>
                                </span>

                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Sous Titre : </b> <span class="float-right">{{ $ouvrage->sous_titre }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Catégorie : </b> <span class="float-right">
                                        <a href="{{$ouvrage->category==null?'#':route('bibliotheque.categories.show',[$ouvrage->ouvrage_category_id])}}">{!! $ouvrage->categoryNom !!}</a>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Lien : </b> <span class="float-right">
                                        <a href="{{$ouvrage->url}}"
                                           target=“_blank”
                                           title="Aller au lien">
                                                        <i>{{$ouvrage->url}}</i>
                                                    </a>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Résumé : </b> <span class="float-right">{{ $ouvrage->resume }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Édition : </b> <span class="float-right">{{ $ouvrage->edition }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Lieu : </b> <span class="float-right">{{ $ouvrage->lieu }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Éditeur : </b> <span class="float-right">{{ $ouvrage->editeur }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Date : </b> <span
                                        class="float-right">{{ Carbon::parse($ouvrage->date)->format('d-m-Y') }}</span>
                                </li>
                                <li class="list-group-item">
                                    <div>
                                        <b>Auteurs : </b>
                                        <span class="float-right">
                                            <button wire:click="initAuteur"
                                                class="btn btn-default mb-1"
                                                data-toggle="modal"
                                                data-target="#add-auteur-modal">
                                                <span
                                                    class="fa fa-plus"></span>
                                            </button>
                                        </span>
                                    </div>
                                    <div class=" wrapper p-2">
                                        @foreach($ouvrage->ouvrage_auteurs as $ouvrage_auteur)
                                            <span class="badge badge-warning m-1 text-xs">
                                        {{$ouvrage_auteur->nom}}
                                        <span title="Supprimer de l'ouvrage" wire:click="deleteAuteur({{$ouvrage_auteur->id}})" class="p-0 btn text-danger btn-xs"><span class="fa fa-close"></span></span>
                                    </span>
                                        @endforeach


                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div>
                                        <b>Étiquettes : </b> <span class="float-right">
                                            <button wire:click="initEtiquette"
                                                class="btn btn-default mb-1"
                                                data-toggle="modal"
                                                data-target="#add-etiquette-modal">
                                                <span
                                                    class="fa fa-plus"></span></button></span>
                                    </div>
                                    <div class=" wrapper p-2">
                                        @foreach($ouvrage->ouvrage_etiquettes as $ouvrage_etiquette)
                                            <span class="badge badge-info m-1 text-xs">
                                        {{$ouvrage_etiquette->nom}}
                                        <span title="Supprimer de l'ouvrage" wire:click="deleteEtiquette({{$ouvrage_etiquette->id}})" class="p-0 btn text-danger btn-xs"><span class="fa fa-close"></span></span>
                                    </span>
                                        @endforeach


                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h5 class="">Statistiques</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Lecteurs : </b> <span class="float-right">0</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Visites : </b> <span class="float-right">0</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Dernière Visite : </b> <span class="float-right">date ici !(human read)</span>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 col-sm-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-one-materiels-tab" data-toggle="pill"
                                       href="#custom-tabs-one-materiels" role="tab"
                                       aria-controls="custom-tabs-one-materiels"
                                       aria-selected="true">Visites</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-categories-tab" data-toggle="pill"
                                       href="#custom-tabs-one-categories" role="tab"
                                       aria-controls="custom-tabs-one-categories" aria-selected="false">Auteurs</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-one-materiels" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-materiels-tab">
                                    {{--<div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th style="width: 50px">#</th>
                                                <th>NOM</th>
                                                <th>DESCRIPTION</th>
                                                <th style="width: 100px">DATE</th>
                                                <th>VIE</th>
                                                <th>RESTE</th>
                                                <th>ÉTAT</th>
                                                <th style="width: 50px"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($category->materiels as $i=>$materiel)
                                                <tr>
                                                    <td>{{ $i+1 }}</td>
                                                    <td>{{ $materiel->nom }}</td>
                                                    <td>{{ $materiel->description }}</td>
                                                    <td>{{ Carbon::parse($materiel->date)->format('d-m-Y') }}</td>
                                                    <td>{{ $materiel->vie }}</td>
                                                    <td>{{ $materiel->vieRestante }}</td>
                                                    <td>{{ $materiel->status->label() }}</td>

                                                    <td>
                                                        <div class="d-flex float-right">
                                                            <a href="#" title="Voir"
                                                               class="btn btn-warning">
                                                                <i class="fas fa-eye"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>--}}
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-categories" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-categories-tab">
                                    <div class="table-responsive">
                                        {{--<table class="table">
                                            <thead>
                                            <tr>
                                                <th style="width: 50px">#</th>
                                                <th>CATÉGORIE</th>
                                                <th>DESCRIPTION</th>
                                                <th>OUVRAGES</th>
                                                <th>AGGRÉGAT</th>
                                                <th style="width: 50px"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($category->categories as $i=>$categ)
                                                <tr>
                                                    <td>{{ $i+1 }}</td>
                                                    <td>
                                                        <a href="{{route('bibliotheque.categories.show',[$categ->id])}}">{!! $categ->nom !!}</a>
                                                    </td>
                                                    <td>{{ $categ->description }}</td>
                                                    <td>{{ $categ->ouvragesCount }}</td>
                                                    <td>{{ $categ->ouvragesCountAggregate }}</td>
                                                    <td>
                                                        <div class="d-flex float-right">
                                                            <button title="Supprimer"
                                                                    class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
