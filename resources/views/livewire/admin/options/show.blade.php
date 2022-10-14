<div class="">


    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <a href="/admin/sections/{{ $section->id }}/edit" title="modifier"
                           class="btn btn-primary btn-sm ml-2">
                            <i class="fas fa-pen"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label>Nom : </label>
                            {{ $section->nom }}
                        </div>
                        <div class="col">
                            <label>Code : </label>
                            {{ $section->code }}
                        </div>

                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="m-0">Options de la section</h4>
                    </div>
                    <div class="card-tools d-flex my-auto">

                        <a href="{{ route('admin.options.create') }}" title="ajouter"
                           class="btn btn-primary mr-2"><span
                                class="fa fa-plus"></span></a>


                    </div>
                </div>

                <div class="card-body p-0 table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>OPTION</th>
                            <th style="width: 100px">CODE</th>

                            <th style="width: 100px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($section->options as $option)
                            <tr>
                                <td><a href="/admin/filieres/{{ $option->id }}">{{ $option->nom }}</a></td>

                                <td>{{ $option->code }}</td>

                                <td>
                                    <div class="d-flex float-right">
                                        <a href="/admin/options/{{ $option->id }}" title="Voir"
                                           class="btn btn-warning">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        {{--  <a href="/filiere-edit/{{ $filiere->id }}" title="modifier" class="btn btn-info  ml-2">
                                             <i class="fas fa-pen"></i>
                                         </a>

                                         <button wire:click="deleteFiliere({{ $filiere->id }})" title="supprimer" class="btn btn-danger ml-2">
                                             <i class="fas fa-trash"></i>
                                         </button> --}}
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
