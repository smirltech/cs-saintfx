@section('title')
    {{Str::upper('cenk')}} - sections
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de sections</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Sections</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
@include('livewire.admin.sections.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">
                               {{-- <livewire:admin.section.section-create-component/>--}}
                                <button type="button"
                                        class="btn btn-primary  ml-2" data-toggle="modal"
                                        data-target="#add-section-modal"><span
                                        class="fa fa-plus"></span> Ajouter section</button>
                            </div>
                        </div>

                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>SECTION</th>

                                    <th>CODE</th>

                                    <th style="width: 100px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($sections as $section)
                                    <tr>
                                        <td>{{ $section->nom }}</td>
                                        <td>{{ $section->code }}</td>
                                        <td>
                                            <div class="d-flex float-right">
                                                <a href="/admin/sections/{{ $section->id }}" title="Voir"
                                                   class="btn btn-warning">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                               <button wire:click="getSelectedSection({{$section}})" type="button"
                                                        class="btn btn-info  ml-2" data-toggle="modal"
                                                        data-target="#edit-section-modal">
                                    <span
                                        class="fa fa-pen"></span></button>
                                                <button wire:click="deleteSection({{ $section->id }})"
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

