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
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ $parent_url }}">{{$classe->filierable->nom}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.classes') }}">Classes</a></li>
                <li class="breadcrumb-item active">{{$classe->grade->label()}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">

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
                                <a href="/admin/classes/{{ $classe->id }}/edit" title="modifier"
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
                                        <button class="btn btn-sm btn-primary"
                                                wire:click="$emit('openModal', 'admin.classe.add-cours-component',{{json_encode(['classe'=>$classe->id])}})"
                                                title="ajouter">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </span>

                                </li>
                                <li class="list-group-item">
                                    <b>Enseignants : </b> <span class="float-right">{{ $enseignants->count() }}</span>
                                </li>
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
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                                       href="#custom-tabs-one-messages" role="tab"
                                       aria-controls="custom-tabs-one-messages" aria-selected="false">Enseignants</a>
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
                                                            <a href="{{route('admin.eleves.show',$inscription->eleve)}}"
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
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                            </div>
                                            <div class="card-tools d-flex my-auto">
                                                <a href="{{ route('admin.classes.create') }}" title="ajouter"
                                                   class="btn btn-primary mr-2"><span
                                                        class="fa fa-plus"></span></a>
                                            </div>
                                        </div>
                                        <div class="card-body p-0 table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>NO.</th>
                                                    <th>NOM</th>
                                                    <th>SECTION</th>
                                                    <th>DESCRIPTION</th>
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
                                                            {{ Str::limit($c->description, 50) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel"
                                 aria-labelledby="custom-tabs-one-messages-tab">
                                <div class="card-body p-0 table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>NO.</th>
                                            <th></th>
                                            <th>NOM</th>
                                            <th>SECTION</th>
                                            <th>COURS</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($enseignants as $key=>$enseignant)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td><img class="img-circle" style="width:30px; height:auto"
                                                         src="{{$enseignant->avatar}}"></td>
                                                <td>{{ $enseignant->nom }}</td>

                                                <td>
                                                    {{ $enseignant->section->nom }}
                                                </td>
                                                @if(!$enseignant->primaire())
                                                    <td>
                                                        {{ $enseignant->cours->count()??'-' }} Cours
                                                    </td>
                                                @else
                                                    <td>
                                                        {{ $enseignant->classe->code??'-' }}
                                                    </td>
                                                @endif

                                                <td>
                                                    <div class="d-flex float-right">
                                                        <button wire:click="delete({{ $enseignant->id }})"
                                                                title="supprimer"
                                                                class="btn btn-outline-danger ml-2">
                                                            <i class="fas fa-trash"></i>
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

                </div>
            </div>
        </div>
    </div>
</div>
</div>
