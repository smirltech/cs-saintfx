@php use App\Models\Filiere; @endphp
@php use App\Models\Option; @endphp
@php use App\Models\Section; @endphp
@section('title')
    {{Str::upper('cenk')}} - classes
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de classes</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Classes</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                            </div>
                            <div class="card-tools d-flex my-auto">
                                <a href="{{ route('scolarite.classes.create') }}" title="ajouter"
                                   class="btn btn-primary mr-2"><span
                                        class="fa fa-plus"></span></a>
                            </div>
                        </div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>CODE</th>
                                    <th>FILIERE</th>
                                    <th>ELEVES</th>
                                    <th>COURS</th>
                                    <th>ENSEIGNANTS</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($classes as $key=>$classe)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $classe->code }}</td>
                                        <td>
                                            <a href="{{$classe->parent_url}}">{{ $classe->filierable->fullName }}</a>
                                        </td>
                                        <td>
                                            {{$classe->inscriptions->count()}}
                                        </td>
                                        <td>
                                            {{$classe->cours->count()}}
                                        </td>
                                        <td>
                                            {{$classe->enseignants->count()}}
                                        </td>
                                        <td>
                                            <div class="d-flex float-right">
                                                <a href="/admin/classes/{{ $classe->id }}" title="Voir"
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="/admin/classes/{{ $classe->id }}/edit" title="modifier"
                                                   class="btn btn-info  btn-sm ml-2">
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                <button wire:click="deleteClasse({{ $classe->id }})"
                                                        title="supprimer" class="btn btn-sm btn-danger ml-2">
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
