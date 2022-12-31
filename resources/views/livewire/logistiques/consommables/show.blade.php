@php  @endphp
@section('title')
    - Consommable - {{$consommable->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-university mr-1"></span>Consommable</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('logistiques.consommables') }}">Consommables</a></li>
                <li class="breadcrumb-item active">{{$consommable->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.logistiques.consommables.modals.crud')
    @include('livewire.logistiques.consommables.modals.mouvement')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="m-0">{{$consommable->nom}}</h4>
                            </div>
                            <div class="card-tools">
                                <span
                                    title="Modifier" role="button" class="ml-2 mr-2" data-toggle="modal"
                                    data-target="#update-consommable-modal">
                                    <span class="fa fa-pen"></span>
                                </span>

                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Description : </b> <span class="float-right">{{ $consommable->description }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Unité : </b> <span class="float-right">{{$consommable->unit->nom}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h5 class="">Résumé Financier</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Quantité : </b> <span class="float-right">{{$consommable->quantite}} {{$consommable->unit->abreviation}}</span>
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
                                    <a class="nav-link active" id="custom-tabs-one-mouvements-tab" data-toggle="pill"
                                       href="#custom-tabs-one-mouvements" role="tab"
                                       aria-controls="custom-tabs-one-mouvements"
                                       aria-selected="true">Operations</a>
                                </li>

                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-one-mouvements" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-mouvements-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h4 class="m-0">Operation du consommable</h4>
                                            </div>
                                            <div class="card-tools">
                                                <button
                                                    title="Ajouter" role="button"
                                                    class="btn btn-outline-primary ml-2 mr-2" data-toggle="modal"
                                                    data-target="#add-operation-modal">
                                                    <span class="fa fa-plus"></span>
                                                </button>

                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 50px">#</th>
                                                        <th>DATE</th>
                                                        <th>BÉNÉFICIAIRE</th>
                                                        <th>FACILITATEUR</th>
                                                        <th>DIRECTION</th>
                                                        <th>QUANTITÉ</th>
                                                        <th style="width: 50px"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($consommable->operations as $i=>$operation)
                                                        <tr>
                                                            <td>{{$i+1}}</td>
                                                            <td>{{$operation->dateFormatted}}</td>
                                                            <td>{{$operation->beneficiaire}}</td>
                                                            <td>{{$operation->facilitateur->name}}</td>
                                                            <td><span class="badge badge-{{$operation->direction->color()}}">{{$operation->direction->label()}}</span></td>
                                                            <td>{{$operation->quantite}} {{$consommable->unit->abreviation}}</td>
                                                        </tr>
                                                    @endforeach
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
    </div>
</div>
