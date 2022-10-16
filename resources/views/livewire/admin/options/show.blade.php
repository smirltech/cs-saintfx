@section('title')
    {{Str::upper('cenk')}} - option - {{$option->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">{{$option->nom}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.options') }}">Options</a></li>
                <li class="breadcrumb-item active">{{$option->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.admin.options.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <button type="button"
                                title="Modifier" class="btn btn-info  ml-2" data-toggle="modal"
                                data-target="#edit-option-modal">
                            <span class="fa fa-pen"></span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label>Code : </label>
                            {{ $option->code }}
                        </div>
                        <div class="col">
                            <label>Option : </label>
                            {{ $option->nom }}
                        </div>
                        <div class="col">
                            <label>Section : </label>
                            <a href="/admin/sections/{{ $option->section->id }}">{{ $option->section->nom }}</a>

                        </div>

                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="m-0">Filières de l'option</h4>
                    </div>
                    <div class="card-tools d-flex my-auto">

                        <button type="button"
                                class="btn btn-primary  ml-2" data-toggle="modal"
                                data-target="#add-filiere-modal"><span
                                class="fa fa-plus"></span></button>

                    </div>
                </div>

                <div class="card-body p-0 table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 200px">CODE</th>
                            <th>FILIERE</th>
                            <th style="width: 100px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($option->filieres as $filiere)
                            <tr>
                                <td>{{ $filiere->code }}</td>
                                <td>{{ $filiere->nom }}</td>
                                <td>
                                    <div class="d-flex float-right">
                                        <a href="/admin/filieres/{{ $filiere->id }}" title="Voir"
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
