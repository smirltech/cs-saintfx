<div class="">


    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <a href="/admin/facultes/{{ $faculte->id }}/edit" title="modifier"
                           class="btn btn-primary btn-sm ml-2">
                            <i class="fas fa-pen"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label>Nom : </label>
                            {{ $faculte->nom }}
                        </div>
                        <div class="col">
                            <label>Code : </label>
                            {{ $faculte->code }}
                        </div>
                        <div class="col">
                            <label>Doyen : </label>
                            {{ $faculte->doyen }}
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <label>Email : </label>
                            {{ $faculte->email }}
                        </div>
                        <div class="col">
                            <label>Phone : </label>
                            {{ $faculte->phone }}
                        </div>
                        <div class="col">
                            <label>Coordonnées : </label>
                            {{ $faculte->latlng }}
                        </div>
                    </div>
                    <div class="mt-4">
                        <label>Description : </label>
                        {{ $faculte->description }}
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="m-0">Filières de la faculté</h4>
                    </div>
                    <div class="card-tools d-flex my-auto">

                        <a href="{{ route('admin.filieres.create') }}" title="ajouter"
                           class="btn btn-primary mr-2"><span
                                class="fa fa-plus"></span></a>


                    </div>
                </div>

                <div class="card-body p-0 table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>FILIERE</th>
                            <th style="width: 100px">CODE</th>
                            <th>DESCRIPTION</th>
                            <th style="width: 100px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($faculte->filieres as $filiere)
                            <tr>
                                <td><a href="/admin/filieres/{{ $filiere->id }}">{{ $filiere->nom }}</a></td>

                                <td>{{ $filiere->code }}</td>
                                <td>{{ $filiere->description }}</td>
                                <td>
                                    <div class="d-flex float-right">
                                        <a href="/admin/filieres/{{ $filiere->id }}" title="Voir"
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
