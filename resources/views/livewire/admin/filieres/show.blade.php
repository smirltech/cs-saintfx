@section('title')
    {{Str::upper('cenk')}} - filière - {{$filiere->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">{{$filiere->nom}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.filieres') }}">Filières</a></li>
                <li class="breadcrumb-item active">{{$filiere->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.admin.filieres.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">

                    <div class="card-tools">
                        <button type="button"
                                title="Modifier" class="btn btn-info  ml-2" data-toggle="modal"
                                data-target="#edit-filiere-modal">
                            <span class="fa fa-pen"></span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label>Code : </label>
                            {{ $filiere->code }}
                        </div>
                        <div class="col">
                            <label>Filière : </label>
                            {{ $filiere->nom }}
                        </div>
                        <div class="col">
                            <label>Option : </label>
                            <a href="/admin/options/{{ $filiere->option->id }}">{{ $filiere->option->nom }}</a>

                        </div>
                        <div class="col">
                            <label>Section : </label>
                            <a href="/admin/sections/{{ $filiere->option->section->id }}">{{ $filiere->option->section->nom }}</a>

                        </div>
                    </div>

                    <div class="mt-4">
                        <label>Description : </label>
                        {{ $filiere->description }}
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="m-0">Classes</h3>
                    </div>
                    <div class="card-tools d-flex my-auto">
                        {{--<a href="{{ route('admin.promotions.create') }}" title="ajouter"
                           class="btn btn-primary mr-2"><span
                                class="fa fa-plus"></span></a>--}}
                    </div>
                </div>

                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>CLASSE</th>
                            <th >CODE</th>
                            <th style="width: 100px"></th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
