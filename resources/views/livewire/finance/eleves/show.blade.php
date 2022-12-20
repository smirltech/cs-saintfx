@php
    use App\Helpers\Helpers;use Carbon\Carbon;
    use App\Enums\GraviteRetard;
@endphp
@section('title')
    {{Str::upper('cenk')}} - élève - {{$eleve->getNomComplet()}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-user mr-1"></span>Élève</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance.finance') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('finance.eleves') }}">Élèves</a></li>
                <li class="breadcrumb-item active">Élève</li>
            </ol>
        </div>
    </div>

@stop
<div>
    @include('livewire.finance.eleves.modals.crud')
    @include('livewire.finance.cards.recu')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">

                            <h3 class="profile-username text-center">{{$eleve->getNomComplet()}}</h3>
                            <p class="text-muted text-center">CODE : {{$inscription->code}}</p>
                            <p class="text-muted text-center">CLASSE
                                : {{$inscription?->classe->code??'Non encore inscrit !'}}</p>
                            <p class="text-muted text-center">ANNEE SCOLAIRE : {{$annee_courante?->nom??''}}</p>
                            <a hidden href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                        </div>

                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Information Personnelle</h3>
                        </div>
                        <div class="card-body">
                            <strong><i class="fas fa-id-card-alt mr-1"></i> Matricule</strong>
                            <p class="text-muted">
                                {{$eleve->matricule??''}}
                            </p>

                            <hr>
                            <strong><i class="fas fa-venus-mars mr-1"></i> Sexe</strong>
                            <p class="text-muted">
                                {{$eleve->sexe->value??''}}
                            </p>
                            <hr>
                            <strong><i class="fas fa-cubes mr-1"></i> Categorie</strong>
                            <p class="text-muted">
                                {{$inscription->categorie->label()??''}}
                            </p>
                            <strong><i class="fas fa-info-circle mr-1"></i> État</strong>
                            <p class="text-muted">
                                {{$inscription->status->label()??''}}
                            </p>

                        </div>

                    </div>
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">État Financier</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                {{--<li class="list-group-item">
                                    <b>Inscription : </b> <span
                                        class="float-right">{{\App\Helpers\Helpers::currencyFormat(0, symbol: 'Fc')}}</span>
                                </li>--}}
                                <li class="list-group-item">
                                    <b>Factures : </b> <span
                                        class="float-right">{{Helpers::currencyFormat($perceptionsDues, symbol: 'Fc')}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Reçus : </b> <span
                                        class="float-right">{{Helpers::currencyFormat($perceptionsPaid, symbol: 'Fc')}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Balance : </b> <span class="float-right"><i
                                            class="badge @if($perceptionsDues > $perceptionsPaid) bg-danger @endif bg-success">{{Helpers::currencyFormat(($perceptionsDues - $perceptionsPaid), symbol: 'Fc')}}</i></span>
                                </li>

                            </ul>
                            <a hidden href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                        </div>

                    </div>

                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="admission">
                                    <div class="">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Frais</h4>
                                                <div class="card-tools">
                                                    <button role="button" class="btn btn-warning"
                                                            data-toggle="modal"
                                                            data-target="#add-perception-modal"><span
                                                            class="fas fa-plus"></span></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="card-body p-0 table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>DATE</th>
                                                            <th>FRAIS</th>
                                                            <th>RAISON</th>
                                                            <th>MONTANT</th>
                                                            <th>PAYÉ</th>
                                                            <th>PAYÉ PAR</th>
                                                            <th>PAYÉ LE</th>
                                                            <th>ECHEANCE</th>
                                                            <th style="width: 100px"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($perceptions as $perception)
                                                            <tr class="@if($perception->montant > $perception->paid) bg- @endif table-{{GraviteRetard::color(Carbon::parse($perception->due_date))}}">
                                                                <td>{{ $perception->created_at->format('d-m-Y') }}</td>
                                                                <td>{{ $perception->frais->nom }}</td>
                                                                <td>{{ $perception->custom_property }}</td>
                                                                <td>{{Helpers::currencyFormat($perception->montant)  }}</td>
                                                                <td>{{Helpers::currencyFormat($perception->paid)  }}</td>
                                                                <td>{{  $perception->paid<=0?'':$perception->paid_by }}</td>
                                                                <td>{{ $perception->paid<=0?'':$perception->updated_at->format('d-m-Y') }}</td>
                                                                <td>{!!$perception->montant<=$perception->paid?'OK':GraviteRetard::retard(Carbon::parse($perception->due_date))!!}</td>
                                                                <td>
                                                                    @if($perception->montant > $perception->paid)
                                                                        <button
                                                                            wire:click="getSelectedPerception({{$perception}})"
                                                                            type="button"
                                                                            title="Payer" class="btn btn-warning"
                                                                            data-toggle="modal"
                                                                            data-target="#pay-perception-modal">
                                                                            Payer
                                                                        </button>
                                                                    @else
                                                                        <button class="btn btn-outline-success">
                                                                            <span
                                                                                class="fa fa-thumbs-up text-success"></span>
                                                                        </button>
                                                                    @endif

                                                                </td>
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
</div>

