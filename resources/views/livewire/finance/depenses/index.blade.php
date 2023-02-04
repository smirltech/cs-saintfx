@php
    $heads =[
        ['label'=>'DATE', 'width'=>10],
        'TYPE',
        'MONTANT',
        'NOTE',
        'REFERENCE',
        'PAR',
        ['label'=>'', 'no-export'=>true, 'width'=>5]
];
   $data =[];
   foreach ($depenses as $depense){
        $data[] =[
            $depense->created_at->format('d-m-Y'),
            $depense->type->nom,
            \App\Helpers\Helpers::currencyFormat($depense->montant, symbol: 'Fc'),
            $depense->note,
            $depense->reference,
            $depense->user->name,
            $depense,
];
   }

    $config =[
  'data'=>$data,
  'order'=>[[1, 'asc']],
  'columns'=>[null, null, null,null,null, null, ['orderable'=>false]],
  'destroy'=>true,

];
@endphp

@section('title')
    - dépenses  {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de dépenses</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Dépenses</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @include('livewire.finance.depenses.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">
                                @can('depenses.create')
                                    <button type="button"
                                            class="btn btn-primary  ml-2" data-toggle="modal"
                                            data-target="#add-depense-modal"><span
                                            class="fa fa-plus"></span></button>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body m-b-40 table-responsive">
                            <x-adminlte-datatable wire:ignore.self theme="light" id="table1" :heads="$heads" striped
                                                  hoverable with-buttons>
                                @foreach($config['data'] as $row)
                                    <tr>
                                        <td>{!! $row[0] !!}</td>
                                        <td>
                                            @can('depense-types.view',$row[6]->depense_type)
                                                <a href="{{route('finance.depense-types.show', [$row[6]->depense_type_id])}}">{{$row[1]}}</a>
                                            @else
                                                {{$row[1]}}
                                            @endcan
                                        </td>

                                        <td>{!! $row[2] !!}</td>
                                        <td>{!! $row[3] !!}</td>
                                        <td>{!! $row[4] !!}</td>
                                        <td>{!! $row[5] !!}</td>
                                        <td>
                                            <div class="d-flex float-right">
                                                @can('depenses.update',$row[6])
                                                    <button wire:click="getSelectedDepense({{$row[6]->id}})"
                                                            type="button"
                                                            title="Modifier" class="btn btn-info  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#edit-depense-modal">
                                                        <span class="fa fa-pen"></span>
                                                    </button>
                                                @endcan
                                                @can('depenses.delete',$row[6])
                                                    <button wire:click="getSelectedDepense({{$row[6]}})" type="button"
                                                            title="supprimer" class="btn btn-danger  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#delete-depense-modal">
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

