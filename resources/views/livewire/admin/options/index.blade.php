@section('title')
    {{Str::upper('cenk')}} - options
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste d'options</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Options</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    <div class="content mt-3">
        <div class="container-fluid">
            <x-validation-errors class="mb-4" :errors="$errors"/>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">
                                <a href="{{ route('admin.options.create') }}" title="ajouter"
                                   class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>
                            </div>
                        </div>

                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>OPTION</th>
                                    <th>CODE</th>
                                    <th>SECTION</th>
                                    <th style="width: 100px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($options as $option)
                                    <tr>
                                        <td>{{ $option->nom }}</td>
                                        <td>{{ $option->code }}</td>
                                        <td><a title="voir cette section" href="/admin/sections/{{ $option->section->id }}">{{ $option->section->nom }}</a></td>
                                        <td>
                                            <div class="d-flex float-right">
                                                <a href="/admin/options/{{ $option->id }}" title="Voir"
                                                   class="btn btn-warning">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                               <a href="/admin/options/{{ $option->id }}/edit" title="modifier"
                                                   class="btn btn-info  ml-2">
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                <button wire:click="deleteOption({{ $option->id }})"
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

