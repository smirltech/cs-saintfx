@php
    use App\Enums\InscriptionStatus;use App\Helpers\Helpers;use App\Models\Classe;use App\Models\Filiere;use App\Models\Option;use App\Models\Section;
@endphp
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span
                    class="fas fa-fw fa-chalkboard-teacher mr-1"></span>Enseignant {{$enseignant->section->nom}}
            </h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.enseignants.index')}}">Enseignants</a></li>
                <li class="breadcrumb-item active">{{$enseignant->nom}}</li>
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
                                <h4 class="m-0">{{$enseignant->nom}}</h4>
                            </div>
                            <div class="card-tools">
                                <a href="{{route('admin.enseignants.edit',$enseignant)}}" title="modifier"
                                   class="ml-2">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle mb-2"
                                     src="{{$enseignant->avatar}}" alt="User profile picture">
                            </div>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Telephone : </b> <span class="float-right">{{$enseignant->telephone}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Email : </b> <span class="float-right">{{$enseignant->email}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Adresse : </b> <span class="float-right">{{$enseignant->adresse}}</span>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    @if($enseignant->primaire())
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4 class="m-0">Classes</h4>
                                </div>
                                <div class="card-tools d-flex my-auto">

                                    <button role="button" class="btn btn-warning"
                                            data-toggle="modal"
                                            data-target="#add-inscription-modal"><span
                                            class="fas fa-plus"></span></button>

                                </div>
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <div class="table-responsive m-b-40">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>CODE</th>
                                            <th>FILIERE</th>
                                            <th>ELEVES</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($classes as $key=>$classe)
                                            <tr>
                                                <td>{{ $classe->code }}</td>

                                                <td>
                                                    <a href="{{$classe->parent_url}}">{{ $classe->filierable->fullName }}</a>
                                                </td>
                                                <td>
                                                    {{ $classe->inscriptions->count() }}
                                                </td>
                                                <td>
                                                    <div class="d-flex float-right">
                                                        <button wire:click="deleteCours({{ $classe->id }})"
                                                                title="Remove" class="btn btn-outline-primary ml-2">
                                                            <i class="fas fa-minus"></i>
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
                    @else
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4 class="m-0">Cours</h4>
                                </div>
                                <div class="card-tools d-flex my-auto">

                                    <button role="button" class="btn btn-warning"
                                            data-toggle="modal"
                                            data-target="#add-inscription-modal"><span
                                            class="fas fa-plus"></span></button>

                                </div>
                            </div>

                            <div class="card-body p-0 table-responsive">
                                <div class="table-responsive m-b-40">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>NO.</th>
                                            <th>NOM</th>
                                            <th>DESCRIPTION</th>
                                            <th>CLASSE</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($cours as $k=>$c)
                                            <tr>
                                                <td>{{ $k+1 }}</td>
                                                <td>{{ $c->nom }}</td>
                                                <td>
                                                    {{ Str::limit($c->description, 100) }}
                                                </td>
                                                <td>{{Classe::find($c->pivot->classe_id)->code}}</td>
                                                <td>
                                                    <div class="d-flex float-right">
                                                        <button wire:click="deleteCours({{ $c->id??'' }})"
                                                                title="Remove" class="btn btn-outline-primary ml-2">
                                                            <i class="fas fa-minus"></i>
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
