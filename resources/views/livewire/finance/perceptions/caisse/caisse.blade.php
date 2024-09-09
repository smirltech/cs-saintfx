@php
    use Carbon\Carbon;
    use App\Enums\GraviteRetard;
    use App\Helpers\Helpers;
@endphp
@section('title')
    Caisse  {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"> Perceptionx </h1>
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
    @include('livewire.finance.perceptions.caisse.modals.paiement')
    @include('livewire.finance.cards.recu')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>Liste d'élèves avec des factures impayées</h4>
                            </div>
                        </div>
                        <div class="card-body m-b-40">
                            <div class="row mb-3">
                                <div class="col-1">
                                    <span class="input-group-text rounded">{{count($inscriptions)}}</span>
                                </div>
                                <div class="col-5">
                                    <x-form::select
                                        wire:model="classe_id"
                                        :options="$classes"
                                        placeholder="Classe"/>
                                </div>

                                <div class="col-5">
                                    <x-form::select
                                        wire:model="inscription_id"
                                        :options="$inscriptionOptions"
                                        placeholder="Elève"/>
                                </div>

                                <div class="col-1">
                                    <button wire:click.debounce="clearSearch" title="Annuler recherche"
                                            class="btn btn-default">
                                        <i class="fas fa-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class=" table-responsive">
                                <table class="table table-striped">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>MATRICULE</th>
                                        <th>NOM</th>
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
                <div class="col-md-5">
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
                                <table class="table table-striped-columns table-borderless mb-3">
                                    @foreach($perceptions as $percept)
                                        <tr>
                                            <td>Facture : {{$percept->frais->nom}} {{$percept->custom_property}}</td>
                                            <td>
                                                {{number_format($percept->balance)}}
                                            </td>
                                            {{-- <td>
                                                 {{number_format($percept->montant)}}
                                             </td>--}}
                                            <td>
                                                <button wire:click="getSelectedPerception('{{$percept->id}}')"
                                                        title="Payer facture"
                                                        class="btn btn-primary btn-sm ml-2"
                                                        data-toggle="modal"
                                                        data-target="#paiement-facture">
                                                    <i class="fas fa-hand-holding-dollar"></i>
                                                </button>
                                            </td>

                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

