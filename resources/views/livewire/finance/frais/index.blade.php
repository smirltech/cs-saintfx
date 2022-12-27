@php
    $heads =[
        ['label'=>'DATE', 'width'=>10],
        'NOM',
        'MONTANT',
        'DESCRIPTION',
        'TYPE',
        'FREQUENCE',
        'CLASSE',
        ['label'=>'', 'no-export'=>true, 'width'=>5]
];
   $data =[];
   foreach ($frais as $fee){
//dd($fee->classable);
        $data[] =[
            $fee->created_at->format('d-m-Y'),
            $fee->nom,
            \App\Helpers\Helpers::currencyFormat($fee->montant, symbol: 'Fc'),
            $fee->description,
            $fee->type->label(),
            $fee->frequence->label(),
           $fee->classable->code??'---',
            $fee,
];
   }

    $config =[
  'data'=>$data,
  'order'=>[[1, 'asc']],
  'columns'=>[null, null,null, null,null,null, null, ['orderable'=>false]],
  'destroy'=>true,

];
@endphp

@section('title')
    - frais  {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Plans de frais</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Frais</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @include('livewire.finance.frais.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                {{--  <span class="ml-2">Section {{$section_id}}</span>
                                  <span class="ml-2">Option {{$option_id}}</span>
                                  <span class="ml-2">Filiere {{$filiere_id}}</span>
                                  <span class="ml-2">Classe {{$classe_id}}</span>--}}
                            </div>
                            <div class="card-tools d-flex my-auto">
                                <button type="button"
                                        class="btn btn-primary  ml-2" data-toggle="modal"
                                        data-target="#add-frais-modal"><span
                                        class="fa fa-plus"></span></button>
                            </div>
                        </div>

                        <div class="card-body m-b-40 table-responsive">
                            <x-adminlte-datatable wire:ignore.self theme="light" id="table1" :heads="$heads" striped
                                                  hoverable with-buttons>
                                @foreach($config['data'] as $row)
                                    <tr>
                                        <td>{!! $row[0] !!}</td>
                                        <td>{!! $row[1] !!}</td>
                                        <td>{!! $row[2] !!}</td>
                                        <td>{!! $row[3] !!}</td>
                                        <td>{!! $row[4] !!}</td>
                                        <td>{!! $row[5] !!}</td>
                                        <td>{!! $row[6] !!}</td>
                                        <td>
                                            <div class="d-flex float-right">
                                                <button wire:click="getSelectedFrais({{$row[7]}})" type="button"
                                                        title="Modifier" class="btn btn-info  ml-2" data-toggle="modal"
                                                        data-target="#edit-frais-modal">
                                                    <span class="fa fa-pen"></span>
                                                </button>

                                                <button wire:click="getSelectedFrais({{$row[7]}})" type="button"
                                                        title="supprimer" class="btn btn-danger  ml-2"
                                                        data-toggle="modal"
                                                        data-target="#delete-frais-modal">
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

