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

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">
                                <livewire:admin.section.section-create-component/>
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
                                                {{--<a href="/admin/sections/{{ $section->id }}/edit" title="modifier"
                                                   class="btn btn-info  ml-2">
                                                    <i class="fas fa-pen"></i>
                                                </a>--}}
                                                {{-- <livewire:admin.section.section-edit-component :section_id="$section->id" :wire:key="'section-edit-component-'.$section->id"/>--}}
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

    <div wire:ignore.self class="modal fade" id="edit-section-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modifier Section</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <x-validation-errors class="mb-4" :errors="$errors"/>
                    <form id="f2" wire:submit.prevent="updateSection">
                        <div class="row">
                            <div class="form-group col-10">
                                <label for="">Nom <i class="text-red">*</i></label>
                                <input type="text" wire:keyup.debounce="genCode" wire:model="nom"
                                       class="form-control @error('nom') is-invalid @enderror">
                                @error('nom')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-2">
                                <label for="">Code <i class="text-red">*</i></label>
                                <input readonly type="text" wire:model="code"
                                       class="form-control @error('code') is-invalid @enderror">
                                @error('code')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button form="f2" type="updateSection" class="btn btn-primary">Soumettre</button>
                </div>
            </div>

        </div>

    </div>

</div>

