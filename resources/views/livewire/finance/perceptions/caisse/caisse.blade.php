@php
    use Carbon\Carbon;
    use App\Enums\GraviteRetard;
    use App\Helpers\Helpers;
@endphp
@section('title')
    - Caisse  {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Caisse</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Caisse</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>Liste d'élèves avec des factures en cours</h4>
                            </div>
                        </div>
                        <div class="card-body m-b-40">
                            <div class="input-group  mb-3">
                                <div class="input-group-prepend mr-2">
                                    <span class="input-group-text rounded">{{count($inscriptions)}}</span>
                                </div>

                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded">Élève : </span>
                                </div>

                                <input wire:keydown.debounce="searchInscription" type="text"
                                       wire:model.debounce="searchTerm"
                                       class="form-control" placeholder="Saisir nom ou matricule de l'élève...">

                                <div class="input-group-append" id="button-addon4">
                                    <button wire:click.debounce="searchInscription" title="Rechercher"
                                            class="input-group-texte rounded btn btn-default">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </div>
                                <div class="input-group-append" id="button-addon4">
                                    <button wire:click.debounce="clearSearch" title="Annuler recherche"
                                            class="btn btn-default  ml-2">
                                        <i class="fas fa-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class=" table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>MATRICULE</th>
                                        <th>ÉLÈVE</th>
                                        <th>CLASSE</th>
                                        <th style="width: 50px;"></th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($inscriptions as $i=>$inscrit)

                                        <tr>
                                            <td>{{$i+1}}</td>
                                            <td>{{$inscrit->matricule}}</td>
                                            <td>{{$inscrit->fullName}}</td>
                                            <td>{{$inscrit->classe->code}}</td>
                                            <td>
                                                <div class="d-flex float-right">
                                                    <button wire:click="getSelectedInscription('{{$inscrit->id}}')"
                                                            title="Voir élève"
                                                            class="btn btn-default btn-sm m-1">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>Élève : {{$inscription?->fullName}}</h4>
                            </div>
                            <div class="card-tools d-flex my-auto">
                                @if($inscription != null)
                                    <button wire:click.debounce="clearSelection" title="Annuler"
                                            class="btn btn-default  ml-2">
                                        <i class="fas fa-close"></i>
                                    </button>
                                @endif

                            </div>
                        </div>
                        <div class="card-body m-b-40">

                            <div class="">
                                <ul class="list-group list-group-unbordered mb-3">
                                    @foreach($perceptions as $percept)
                                        <li class="list-group-item">
                                            <b>Facture info : {{$percept->frais->nom}} </b> <span
                                                class="float-right">{{number_format($percept->balance, 2)}} Fc
                                            <button wire:click="getSelectedPerception('{{$percept->id}}')"
                                                    title="Payer facture"
                                                    class="btn btn-default btn-sm ml-2">
                                                        <i class="fas fa-hand-holding-dollar"></i>
                                                    </button>
                                            </span>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

