@php use App\Models\Filiere; @endphp
@php use App\Models\Option; @endphp
@php use App\Models\Section; @endphp
@section('title')
    {{Str::upper('cenk')}} - Cours
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de cours</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Cours</li>
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
                                <a href="{{ route('admin.cours.create') }}" title="ajouter"
                                   class="btn btn-primary mr-2"><span
                                        class="fa fa-plus"></span></a>
                            </div>
                        </div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>CODE</th>
                                    <th>NOM</th>
                                    <th>DESCRIPION</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($cours as $c)
                                    <tr>
                                        <td>{{ $c->code }}</td>
                                        <td>{{ $c->nom }}</td>

                                        <td>
                                            {{ $c->description }}
                                        </td>
                                        <td>
                                            <div class="d-flex float-right">
                                                <a href="/admin/classes/{{ $c->id }}" title="Voir"
                                                   class="btn btn-warning">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="/admin/classes/{{ $c->id }}/edit" title="modifier"
                                                   class="btn btn-info  ml-2">
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                <button wire:click="deleteClasse({{ $c->id }})"
                                                        title="supprimer" class="btn btn-danger ml-2">
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
