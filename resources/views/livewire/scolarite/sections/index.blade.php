@php
    $heads =[
        ['label'=>'CODE', 'width'=>5],
        'SECTION',
        ['label'=>'', 'no-export'=>true, 'width'=>5]
];
   $datas =[];
   foreach ($sections as $section){
        $datas[] =[
            $section->code,
            $section->nom,
            $section,
];
   }

    $config =[
  'data'=>$datas,
  'order'=>[[1, 'asc']],
  'columns'=>[null, null, ['orderable'=>false]],
  'destroy'=>false,

];
@endphp

@section('title')
    - sections
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de sections</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Sections</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @include('livewire.scolarite.sections.modals.crud')

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
                                @can('sections.create')
                                    <button type="button"
                                            class="btn btn-primary  ml-2" data-toggle="modal"
                                            data-target="#add-section-modal"><span
                                            class="fa fa-plus"></span></button>
                                @endcan
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
                                        <td>
                                            <div class="d-flex float-right">
                                                @can('sections.view', $row[2])
                                                    <a href="/scolarite/sections/{{ $row[2]->id }}" title="Voir"
                                                       class="btn btn-warning">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('sections.update', $row[2])
                                                    <button wire:click="getSelectedSection({{$row[2]}})" type="button"
                                                            title="Modifier" class="btn btn-info  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#edit-section-modal">
                                                        <span class="fa fa-pen"></span>
                                                    </button>
                                                @endcan
                                                    @can('sections.delete', $row[2])
                                                <button wire:click="getSelectedSection({{$row[2]}})" type="button"
                                                        title="supprimer" class="btn btn-danger  ml-2"
                                                        data-toggle="modal"
                                                        data-target="#delete-section-modal">
                                                    <span class="fa fa-trash"></span>
                                                </button>
                                                    @endcan
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

