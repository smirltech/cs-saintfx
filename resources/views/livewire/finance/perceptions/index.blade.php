@php
    use Carbon\Carbon;
    use App\Enums\GraviteRetard;
    use App\Helpers\Helpers;
@endphp
@section('title')
    Finance | Perceptions  {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de perceptions</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Élèves</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @php
        $heads =[
            ['label'=>'#', 'width'=>2],
            ['label'=>'DATE', 'width'=>10],
            'FRAIS',
            'ELEVE',
            'CLASSE',
            'MONTANT',
            'PAYE',
            'SOLDE',
             ['label'=>'ECHEANCE', 'width'=>8],
            ['label'=>'', 'no-export'=>true, 'width'=>5]
    ];
       $data =[];
       foreach ($perceptions as $key=>$perception){

            $data[] =[
                $key+1,
                $perception->created_at->format('d-m-Y'),
                $perception->frais->nom,
                $perception->inscription?->eleve->fullName,

                $perception->inscription?->classe->code,
                $perception->montant,
                (int)($perception->paid),
                ( $perception->montant-(int)($perception->paid)),
                Carbon::parse($perception->due_date),
                $perception->id,
    ];
       }

        $config =[
      'data'=>$data,
      'order'=>[[1, 'desc']],
      'columns'=>[null,null, null,null,null,null, null,null, null, ['orderable'=>false]],
      'destroy'=>true,

    ];
    @endphp
    @include('livewire.finance.perceptions.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">
                                @can('perceptions.create')
                                    <a href="{{route('finance.perceptions.create')}}" title="voir"
                                       class="btn btn-primary  ml-2">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body m-b-40 table-responsive">
                            <x-adminlte-datatable wire:ignore.self head-theme="dark" theme="light" id="table1"
                                                  :heads="$heads" striped
                                                  hoverable with-buttons>
                                @foreach($config['data'] as $row)
                                    <tr class="table-{{GraviteRetard::color($row[8])}}">
                                        <td>{!! $row[0] !!}</td>
                                        <td>{!! $row[1] !!}</td>
                                        <td>{!! $row[2] !!}</td>
                                        <td>{!! $row[3] !!}</td>

                                        <td>{!! $row[4] !!}</td>

                                        <td>{!! Helpers::currencyFormat($row[5]) !!} Fc</td>
                                        <td>
                                            {!! Helpers::currencyFormat($row[6]) !!} Fc</td>
                                        <td><span
                                                class="badge @if($row[7] > 0) badge-danger @else badge-success @endif">{!! Helpers::currencyFormat($row[7]) !!} Fc</span>
                                        </td>
                                        <td title="{!! $row[8]->format('d-m-Y') !!}">{!!$row[7]<=0?'OK':GraviteRetard::retard($row[8])!!}</td>
                                        <td>
                                            <div class="d-flex float-right">
                                                @can('perceptions.update',$row[9])
                                                    <a href="{{route('finance.perceptions.edit', ['perception'=>$row[9]])}}"
                                                       title="voir"
                                                       class="btn btn-success  ml-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('perceptions.delete',$row[9])
                                                    <button wire:click="getSelectedPerception({{$row[9]}})"
                                                            type="button"
                                                            title="Modifier" class="btn btn-danger  ml-4"
                                                            data-toggle="modal"
                                                            data-target="#delete-perception">
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

