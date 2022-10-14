@section('title')
    {{Str::upper('cenk')}} - filières
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de filières</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Filières</li>
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

                                <a href="{{ route('admin.filieres.create') }}" title="ajouter" class="btn btn-primary mr-2"><span
                                        class="fa fa-plus"></span></a>


                            </div>
                        </div>

                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>FILIERE</th>
                                        <th >CODE</th>
                                        <th >OPTION</th>
                                        <th style="width: 100px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($filieres as $filiere)
                                        <tr>
                                            <td>{{ $filiere->nom }}</td>
                                            <td>{{ $filiere->code }}</td>
                                            <td><a href="/admin/options/{{ $filiere->option->id }}">{{ $filiere->option->nom }}</a></td>

                                            <td>
                                                <div class="d-flex float-right">
                                                    <a href="/admin/filieres/{{ $filiere->id }}" title="Voir" class="btn btn-warning">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="/admin/filieres/{{ $filiere->id }}/edit" title="modifier" class="btn btn-info  ml-2">
                                                        <i class="fas fa-pen"></i>
                                                    </a>

                                                    <button wire:click="deleteFiliere({{ $filiere->id }})" title="supprimer" class="btn btn-danger ml-2">
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
