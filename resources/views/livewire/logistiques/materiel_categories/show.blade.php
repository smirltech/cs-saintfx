@section('title')
     - Categorie - {{$category->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-university mr-1"></span>Catégorie de Matériel</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('logistiques.categories') }}">Catégories</a></li>
                <li class="breadcrumb-item active">{{$category->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    @include('livewire.logistiques.materiel_categories.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="m-0">{{$category->nom}}</h4>
                            </div>
                            <div class="card-tools">
                                <span
                                    title="Modifier" role="button" class="ml-2 mr-2" data-toggle="modal"
                                    data-target="#update-category-modal">
                                    <span class="fa fa-pen"></span>
                                </span>

                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Groupe : </b> <span class="float-right">
                                        <a href="{{$category->groupe==null?'#':route('logistiques.categories.show',[$category->groupe?->id])}}">{!! $category->groupe?->nom !!}</a>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Description : </b> <span class="float-right">{{ $category->description }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 col-sm-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-one-materiels-tab" data-toggle="pill"
                                       href="#custom-tabs-one-materiels" role="tab" aria-controls="custom-tabs-one-materiels"
                                       aria-selected="true">Matériels</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-categories-tab" data-toggle="pill"
                                       href="#custom-tabs-one-categories" role="tab"
                                       aria-controls="custom-tabs-one-categories" aria-selected="false">Catégories</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-one-materiels" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-materiels-tab">
                                    <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 50px">#</th>
                                                        <th>NOM</th>
                                                        <th style="width: 50px"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($category->materiels as $i=>$materiel)
                                                        <tr>
                                                            <td>{{ $i+1 }}</td>
                                                            <td>{{ $materiel->nom }}</td>


                                                            <td>
                                                                <div class="d-flex float-right">
                                                                    <a href="#" title="Voir"
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
                                <div class="tab-pane fade" id="custom-tabs-one-categories" role="tabpanel"
                                     aria-labelledby="custom-tabs-one-categories-tab">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th style="width: 50px">#</th>
                                                <th>CATÉGORIE</th>
                                                <th style="width: 50px"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($category->categories as $i=>$categ)
                                                <tr>
                                                    <td>{{ $i+1 }}</td>
                                                    <td>
                                                        <a href="{{route('logistiques.categories.show',[$categ->id])}}">{!! $categ->nom !!}</a>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex float-right">
                                                            <button title="Supprimer"
                                                               class="btn btn-danger">
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
        </div>
    </div>
</div>
