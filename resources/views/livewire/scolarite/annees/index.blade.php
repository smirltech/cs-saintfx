@section('title')
     - années scolaires
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-calendar-alt"></span> Liste d'années</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Années scolaires</li>
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
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#add-annee-modal">
                                    <span
                                        class="fa fa-plus"></span></button>
                            </div>
                        </div>

                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Année Scolaire</th>
                                    <th style="width: 100px">État</th>
                                    <th style="width: 100px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($annees as $annee)
                                    <tr>
                                        <td>
                                            <div class="d-flex">{{ $annee->nom}}</div>
                                        </td>
                                        <td>
                                            @if($annee->encours)
                                            <span class="badge badge-success p-1">EN COURS</span>
                                            @else
                                                <button title="Metter en cours"
                                                        wire:click="setAnneeEnCours({{ $annee->id }})"
                                                        class="btn btn-warning btn-sm mr-2">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex float-right">
                                                @if (!$annee->encours)
                                                    <button wire:click="editAnnee({{ $annee->id }})" type="button"
                                                            title="Modifier"
                                                            class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#edit-annee-modal">
                                                        <i class="fas fa-pen"></i></button>

                                                    <button title="supprimer"
                                                            wire:click="deleteAnnee({{ $annee->id }})"
                                                            class="btn btn-danger btn-sm ml-1">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif

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

    <div wire:ignore.self class="modal fade" id="add-annee-modal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter Année Scolaire</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="form-control" type="number" wire:model="nom"
                           placeholder="Année debut">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button wire:click="addAnnee" type="submit" data-dismiss="modal" class="btn btn-primary">Soumettre
                    </button>
                </div>
            </div>

        </div>

    </div>

    <div wire:ignore.self class="modal fade" id="edit-annee-modal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modifier Année Scolaire</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="form-control" type="text" wire:model="nom"
                           placeholder="Année debut">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button wire:click="updateAnnee" type="button" class="btn btn-primary" data-dismiss="modal">
                        Soumettre
                    </button>
                </div>
            </div>

        </div>

    </div>

</div>



