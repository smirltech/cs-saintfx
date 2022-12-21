@php
    use App\Enums\InscriptionStatus;use App\Helpers\Helpers;
@endphp

@section('title')
    {{Str::upper('cenk')}} - {{$classe->code}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-chalkboard-teacher mr-1"></span>Classe</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ $parent_url }}">{{$classe->filierable->nom}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.classes') }}">Classes</a></li>
                <li class="breadcrumb-item active">{{$classe->grade->label()}}</li>
            </ol>
        </div>
    </div>
@stop
<div class="content mt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="card-title">
                            <h4 class="m-0">{{$classe->grade->label()}}</h4>
                        </div>
                        <div class="card-tools">
                            <a href="/scolarite/classes/{{ $classe->id }}/edit" title="modifier"
                               class="ml-2">
                                <i class="fas fa-pen"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Code : </b> <span class="float-right">{{ $classe->code }}</span>
                            </li>

                            <li class="list-group-item">
                                <b>Élèves : </b> <span class="float-right">{{ $inscriptions->count() }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Cours : {{ $cours->count() }}</b>
                                <span class="float-right">
                                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#add-cours-modal" title="ajouter">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </span>

                            </li>
                            @if($classe->primaire())
                                <li class="list-group-item">
                                    <b>Enseignant : </b> <span
                                        class="float-right"><a
                                            href="{{$classe->enseignant?route('scolarite.enseignants.show',$classe->enseignant):route('scolarite.classes.edit',$classe)}}">{{ $classe->enseignant->nom??'Ajouter un enseignant' }}</a></span>
                                </li>
                            @else
                                <li class="list-group-item">
                                    <b>Enseignants : </b> <span class="float-right">{{ $enseignants->count() }}</span>
                                </li>
                            @endif
                            <li class="list-group-item">
                                <b>{{ $parent }} : </b> <span class="float-right"> <a
                                        href="{{ $parent_url }}">{{  $classe->filierable->nom }}</a>
         </span>
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
                                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                                   href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                   aria-selected="true">Elèves</a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                                   href="#custom-tabs-one-profile" role="tab"
                                   aria-controls="custom-tabs-one-profile" aria-selected="false">Cours</a>
                            </li>
                            @if(!$classe->primaire())
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                                       href="#custom-tabs-one-messages" role="tab"
                                       aria-controls="custom-tabs-one-messages" aria-selected="false">Enseignants</a>
                                </li>
                            @endif
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                                       href="#custom-tabs-resultats" role="tab"
                                       aria-controls="custom-tabs-resultats" aria-selected="false">Résultats</a>
                                </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
                                 aria-labelledby="custom-tabs-one-home-tab">
                                <div class="table-responsive m-b-40">
                                    <table class="table ">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>MATRICULE</th>
                                            <th>NOM</th>
                                            <th>SEXE</th>
                                            <th style="width: 100px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($inscriptions->sortBy(fn ($q) => $q->eleve->fullName) as $inscription)
                                            <tr>
                                                <td><img class="img-circle" style="width:30px; height:auto"
                                                         src="{{$inscription->eleve->profile_url}}"></td>
                                                <td>{{ $inscription->code }}</td>
                                                <td>{{ $inscription->eleve->fullName }}</td>
                                                <td>{{ $inscription->eleve->sexe }}</td>
                                                <td>
                                                    <div class="d-flex float-right">
                                                        <a href="{{route('scolarite.eleves.show',$inscription->eleve)}}"
                                                           title="Voir"
                                                           class="btn btn-warning btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                                 aria-labelledby="custom-tabs-one-profile-tab">
                                <div class="card-body p-0 table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>NO.</th>
                                            <th>NOM</th>
                                            <th>SECTION</th>
                                            <th>ENSEIGNANT</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($cours as $k=>$c)
                                            <tr>
                                                <td>{{ $k+1 }}</td>
                                                <td>{{ $c->nom }}</td>
                                                <td>
                                                    {{ $c->section->nom }}
                                                </td>
                                                <td>
                                                    {{ $c->enseignant->nom??'Aucun' }}
                                                </td>
                                                <td>
                                                    <div class="d-flex float-right">
                                                        <button wire:click="editCours({{ $c->id }})"
                                                                title="Modifier"
                                                                class="btn btn-outline-warning ml-2">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if(!$classe->primaire())
                                <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-messages-tab">
                                    <div class="card-body p-0 table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>NOM</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($enseignants as $key=>$enseignant)
                                                <tr>
                                                    <td><img class="img-circle" style="width:30px; height:auto"
                                                             src="{{$enseignant->avatar}}"></td>
                                                    <td>{{ $enseignant->nom }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                            <div class="tab-pane fade" id="custom-tabs-resultats" role="tabpanel"
                                 aria-labelledby="custom-tabs-one-resultats">
                                <div class="card-body p-0 table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>PLACE</th>
                                            <th>ÉLÈVE</th>
                                            <th>POURCENT</th>
                                            <th></th>
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
    @include('livewire.scolarite.classes.modals')
</div>

