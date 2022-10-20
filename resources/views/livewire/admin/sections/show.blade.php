@section('title')
    {{Str::upper('cenk')}} - section - {{$section->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">{{$section->nom}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.sections') }}">Sections</a></li>
                <li class="breadcrumb-item active">{{$section->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.admin.sections.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <button type="button"
                                title="Modifier" class="btn btn-info  ml-2" data-toggle="modal"
                                data-target="#edit-section-modal">
                            <span class="fa fa-pen"></span>
                        </button>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label>Code : </label>
                            {{ $section->code }}
                        </div>
                        <div class="col">
                            <label>Nom : </label>
                            {{ $section->nom }}
                        </div>

                    </div>

                </div>
            </div>
            @if(count($section->options) > 0)
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="m-0">Options</h4>
                    </div>
                    <div class="card-tools d-flex my-auto">
                        <button type="button"
                                class="btn btn-primary  ml-2" data-toggle="modal"
                                data-target="#add-option-modal"><span
                                class="fa fa-plus"></span></button>
                    </div>
                </div>

                <div class="card-body p-0 table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 200px">CODE</th>
                            <th>OPTION</th>

                            <th style="width: 100px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($section->options as $option)
                            <tr>
                                <td>{{ $option->code }}</td>
                                <td>{{ $option->nom }}</td>


                                <td>
                                    <div class="d-flex float-right">
                                        <a href="/admin/options/{{ $option->id }}" title="Voir"
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
            @endif
            @if(count($classes) > 0)
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="m-0">Classes</h4>
                    </div>
                    <div class="card-tools d-flex my-auto">
                       {{-- <a href="{{ route('admin.classes.create') }}" title="ajouter"
                           class="btn btn-primary mr-2"><span
                                class="fa fa-plus"></span></a>--}}
                    </div>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 100px">CODE</th>
                            <th>CLASSE</th>
                           {{-- <th></th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($classes as $classe)
                            <tr>
                                <td>{{ $classe->code }}</td>
                                <td>{{ $classe->grade->label() }}</td>
                               {{-- <td>
                                    <div class="d-flex float-right">
                                        <a href="/admin/classes/{{ $classe->id }}" title="Voir"
                                           class="btn btn-warning">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/admin/classes/{{ $classe->id }}/edit" title="modifier"
                                           class="btn btn-info  ml-2">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <button wire:click="deleteClasse({{ $classe->id }})"
                                                title="supprimer" class="btn btn-danger ml-2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
