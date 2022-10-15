@section('title')
    {{Str::upper('cenk')}} - années scolaires
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste d'années</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
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

                                @if ($isAdding)

                                    <input class="form-control" type="number" wire:model="nom"
                                           placeholder="Année debut">

                                    <button title="ajouter" wire:click="addAnnee" class="btn btn-default ml-2"><span
                                            class="fa fa-arrow-right"></span></button>
                                    <button title="annuler" class="btn btn-default ml-2"
                                            wire:click="toggleIsAdding"><span
                                            class="fa fa-times"></span></button>
                                @else
                                    <button  title="ajouter" class="btn btn-primary mr-2"
                                            wire:click="toggleIsAdding"><span
                                            class="fa fa-plus"></span></button>
                                @endif

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
                                            <div class="d-flex">
                                                @if ($annee_id == $annee->id)

                                                    <input class="form-control" type="number" wire:model="nom"
                                                           placeholder="Année debut">

                                                    <button title="modifier" wire:click="updateAnnee"
                                                            class="btn btn-default ml-2"><span
                                                            class="fa fa-arrow-right"></span></button>
                                                    <button title="annuler" class="btn btn-default ml-2"
                                                            wire:click="resetAnneeId"><span
                                                            class="fa fa-times"></span></button>
                                                @else
                                                    {{ $annee->nom}}
                                                @endif
                                            </div>

                                        </td>
                                        <td>{{ $annee->encours ? 'EN COURS' : '' }}</td>
                                        <td>

                                            <div class="d-flex float-right">
                                                @if ($annee_id == -1)
                                                    @if (!$annee->encours)
                                                        <button title="metter en cours"
                                                                wire:click="setAnneeEnCours({{ $annee->id }})"
                                                                class="btn bg-yellow mr-2">
                                                            <i class="fas fa-check"></i>
                                                        </button>

                                                        <button title="modifier"
                                                                wire:click="editAnnee({{ $annee->id }})"
                                                                class="btn btn-info">
                                                            <i class="fas fa-pen"></i>
                                                        </button>
                                                        <button title="supprimer"
                                                                wire:click="deleteAnnee({{ $annee->id }})"
                                                                class="btn btn-danger ml-2">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
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
</div>
