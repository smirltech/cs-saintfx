@php
    $heads =[
        ['label'=>'#', 'width'=>5],
        'CATEGORIE',
        'GROUPE',
        'DESCRIPTION',
        ['label'=>'', 'no-export'=>true, 'width'=>5]
];
   //$datas =[];
   foreach ($categories as $i=>$categorie){
        $datas[] =[
            $i+1,
            $categorie->nom,
            $categorie->groupe,
            $categorie->description,
            $categorie,
];
   }

    $config =[
  'data'=>$datas,
  'order'=>[[1, 'asc']],
  'columns'=>[null,null,null, null, ['orderable'=>false]],
  'destroy'=>false,

];
@endphp

@section('title')
    - catégories de patrimoine
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de catégories</h1>
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
    @include('livewire.logistiques.materiel_categories.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">
                                {{-- <livewire:scolarite.section.section-create-component/>--}}
                                <button type="button"
                                        class="btn btn-primary  ml-2" data-toggle="modal"
                                        data-target="#add-category-modal"><span
                                        class="fa fa-plus"></span></button>
                            </div>
                        </div>

                        <div class="card-body m-b-40 table-responsive">
                            <x-adminlte-datatable wire:ignore.self theme="light" id="table1" :heads="$heads" striped
                                                  hoverable
                                                  with-buttons>
                                @foreach($config['data'] as $row)
                                    <tr>
                                        <td>{!! $row[0] !!}</td>
                                        <td>{!! $row[1] !!}</td>
                                        <td>{!! $row[2] !!}</td>
                                        <td>{!! $row[3] !!}</td>
                                        <td>
                                            <div class="d-flex float-right">
                                                <a href="/patrimoine/categories/{{ $row[4]->id }}" title="Voir"
                                                   class="btn btn-warning">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button wire:click="getSelectedCategory({{$row[4]}})" type="button"
                                                        title="Modifier" class="btn btn-info  ml-2" data-toggle="modal"
                                                        data-target="#edit-category-modal">
                                                    <span class="fa fa-pen"></span>
                                                </button>

                                                <button wire:click="getSelectedCategory({{$row[4]}})" type="button"
                                                        title="supprimer" class="btn btn-danger  ml-2"
                                                        data-toggle="modal"
                                                        data-target="#delete-category-modal">
                                                    <span class="fa fa-trash"></span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

