@section('title')
    - catégories d'ouvrages
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de catégories d'ouvrages</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Catégories</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @include('livewire.bibliotheque.categories.modals.crud')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">

                                <button type="button"
                                        class="btn btn-primary  ml-2" data-toggle="modal"
                                        data-target="#add-category-modal"><span
                                        class="fa fa-plus"></span></button>
                            </div>
                        </div>

                        <div class="card-body m-b-40">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px">#</th>
                                        <th>NOM</th>
                                        <th>GROUPE</th>
                                        <th>DESCRIPTION</th>
                                        <th style="width: 50px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories as $i=>$category)
                                        <tr>
                                            <td>{{$i+1}}</td>
                                            <td>{{$category->nom}}</td>
                                            <td>{{$category->groupeNom}}</td>
                                            <td>{{$category->description}}</td>
                                            <td>
                                                <div class="d-flex float-right">
                                                    <a href="{{route('bibliotheque.categories.show',[$category->id])}}"
                                                       title="Voir"
                                                       class="btn btn-warning">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button wire:click="getSelectedCategory({{$category}})" type="button"
                                                            title="Modifier" class="btn btn-info  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#update-category-modal">
                                                        <span class="fa fa-pen"></span>
                                                    </button>

                                                    <button wire:click="getSelectedCategory({{$category}})" type="button"
                                                            title="supprimer" class="btn btn-danger  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#delete-category-modal">
                                                        <span class="fa fa-trash"></span>
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
</div>

