@php use Carbon\Carbon; @endphp
@section('title')
     - Matériel - {{$materiel->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-university mr-1"></span>Matériel</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('logistiques.materiels') }}">Matériels</a></li>
                <li class="breadcrumb-item active">{{$materiel->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.logistiques.materiels.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="m-0">{{$materiel->nom}}</h4>
                            </div>
                            <div class="card-tools">
                                <span
                                    title="Modifier" role="button" class="ml-2 mr-2" data-toggle="modal"
                                    data-target="#update-materiel-modal">
                                    <span class="fa fa-pen"></span>
                                </span>

                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Catégorie : </b> <span class="float-right">
                                        <a href="{{route('logistiques.categories.show',[$materiel->categoryId])}}">{!! $materiel->categoryNom !!}</a>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Description : </b> <span class="float-right">{{ $materiel->description }}</span>
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
                                    <b>Valeur Initiale : </b> <span class="float-right">{{number_format($materiel->montant)}} Fc</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Année Mise en Service : </b> <span class="float-right">{{$materiel->dateFormatted}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Durée de Vie : </b> <span class="float-right">{{$materiel->vie}} ans</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Methode d'Amortissement : </b> <span class="float-right">Linéaire</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Taux d'Amortissement : </b> <span class="float-right">{{number_format($materiel->amortissementTaux)}} %</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Amortissement Annuelle : </b> <span class="float-right">{{number_format($materiel->amortissement)}} Fc</span>
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
                                       href="#custom-tabs-one-materiels" role="tab" aria-controls="custom-tabs-one-materiels"
                                       aria-selected="true">Amortissement</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-categories-tab" data-toggle="pill"
                                       href="#custom-tabs-one-categories" role="tab"
                                       aria-controls="custom-tabs-one-categories" aria-selected="false">Cession</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-one-materiels" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-materiels-tab">
                                    <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 50px">#</th>
                                                        <th>ANNÉE</th>
                                                        <th>AMORTISSEMENT</th>
                                                        <th>RÉSIDU</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-categories" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-categories-tab">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th style="width: 50px">#</th>
                                                <th>CATÉGORIE</th>
                                                <th>DESCRIPTION</th>
                                                <th>MATÉRIELS</th>
                                                <th>AGGRÉGAT</th>
                                                <th style="width: 50px"></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
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
