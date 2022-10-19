@php
    use App\Enum\InscriptionStatus;
    use App\Helpers\Helpers;use App\Models\Annee;
@endphp
@section('title')
    {{Str::upper('cenk')}} - responsable - {{$responsable->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            {{--<h1 class="ms-3">{{$responsable->nom}}</h1>--}}
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.responsables') }}">Responsables</a></li>
                <li class="breadcrumb-item active">{{$responsable->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="  wire:ignore.self">
    @include('livewire.admin.responsables.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">{{$responsable->nom}}</h1>
                    <div class="card-tools">
                        <button wire:click.debounce="fillDataToModal" type="button"
                                title="Modifier" class="btn btn-info  ml-2" data-toggle="modal"
                                data-target="#edit-responsable-modal">
                            <span class="fa fa-pen"></span></button>
                        <button type="button"
                                title="supprimer" class="btn btn-danger  ml-4" data-toggle="modal"
                                data-target="#delete-responsable-modal">
                            <span class="fa fa-trash"></span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label>Nom : </label>
                            {{ $responsable->nom }}
                        </div>
                        <div class="col">
                            <label>Sexe : </label>
                            {{ $responsable->sexe->value }}
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Phone : </label>
                            <a href="tel:{{ $responsable->telephone }}">{{ $responsable->telephone }}</a>
                        </div>
                        <div class="col">
                            <label>E-mail : </label>
                            <a href="mailto:{{ $responsable->email }}">{{ $responsable->email }}</a>
                        </div>
                        <div class="col">
                            <label>Adresse : </label>
                            {{ $responsable->adresse }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="m-0">Enfants</h3>
                    </div>
                    <div class="card-tools d-flex my-auto">
                        {{--<button type="button"
                                class="btn btn-primary  ml-2" data-toggle="modal"
                                data-target="#add-classe-modal"><span
                                class="fa fa-plus"></span></button>--}}
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive m-b-40">
                        <table class="table">
                            <thead>
                            <tr>
                                <th style="width: 100px">CODE</th>
                                <th>ELEVE</th>
                                <th>SEXE</th>
                                <th>AGE</th>
                                <th>TELEPHONE</th>
                                <th>EMAIL</th>
                                <th>RELATION</th>
                                <th style="width: 100px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($responsable->responsable_eleves as $responsable_eleve)
                                <tr>
                                    <td>{{ $responsable_eleve->eleve->code }}</td>
                                    <td>{{ $responsable_eleve->eleve->fullName }}</td>
                                    <td>{{ $responsable_eleve->eleve->sexe }}</td>
                                    <td>{{ $responsable_eleve->eleve->date_naissance->age??'' }}</td>
                                    <td>{{ $responsable_eleve->eleve->telephone }}</td>
                                    <td>{{ $responsable_eleve->eleve->email }}</td>
                                    <td>{{ $responsable_eleve?->relation?->reverse($responsable_eleve->eleve->sexe)??'' }}<span wire:click="selectResponsableEleve({{$responsable_eleve->id}})" type="button"
                                                                                                                                  title="Modifier Relation" class="ml-2" data-toggle="modal"
                                                                                                                                  data-target="#edit-relation-modal">
                                            <span class="fa fa-link"></span>
                                        </span></td>
                                    <td>
                                       <div class="d-flex float-right">
                                             <a href="/admin/eleves/{{ $responsable_eleve->eleve->id }}" title="Voir"
                                               class="btn btn-warning">
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
            </div>
        </div>
    </div>
</div>
