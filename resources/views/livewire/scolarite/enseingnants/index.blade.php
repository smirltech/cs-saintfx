@php use App\Models\Filiere; @endphp
@php use App\Models\Option; @endphp
@php use App\Models\Section; @endphp
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">{{$title}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Enseignants</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.scolarite.enseingnants.modals.delete')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                            </div>
                            <div class="card-tools d-flex my-auto">
                                @can('enseignants.create')
                                    <a href="{{ route('scolarite.enseignants.create') }}" title="ajouter"
                                       class="btn btn-primary mr-2"><span
                                            class="fa fa-plus"></span></a>
                                @endcan
                            </div>
                        </div>
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
                                        <td><img class="img-circle" style="width:50px; height:50px"
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
                                                @can('enseignants.view',$enseignant)
                                                    <a href="/scolarite/enseignants/{{ $enseignant->id }}" title="Voir"
                                                       class="btn btn-outline-primary ml-2">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('enseignants.update',$enseignant)
                                                    <a href="/scolarite/enseignants/{{ $enseignant->id }}/edit"
                                                       title="modifier"
                                                       class="btn btn-outline-info  ml-2">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                @endcan
                                                @can('enseignants.delete',$enseignant)
                                                    <button wire:click="getSelectedEnseignant('{{$enseignant->id }}')"
                                                            type="button"
                                                            title="supprimer" class="btn btn-outline-danger  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#delete-enseignant">
                                                        <span class="fa fa-trash"></span>
                                                    </button>
                                                @endcan
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
