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

                                <a href="{{ route('admin.sections.create') }}" title="ajouter"
                                   class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>


                            </div>
                        </div>

                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>SECTION</th>

                                    <th style="width: 100px">CODE</th>

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
                                               <a href="/admin/sections/{{ $section->id }}/edit" title="modifier"
                                                   class="btn btn-info  ml-2">
                                                    <i class="fas fa-pen"></i>
                                                </a>

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

