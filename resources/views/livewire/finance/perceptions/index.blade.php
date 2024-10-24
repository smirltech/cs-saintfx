@php
    use App\Models\Perception;use Carbon\Carbon;
    use App\Enums\GraviteRetard;
    use App\Helpers\Helpers;

    $heads =[
        ['label'=>'DATE', 'width'=>10],
        'LIBELLE',
        'ELEVE',
        'CLASSE',
        'DU',
        'PAYE',
        'RESTE',
        'CAISSIER',
        ['label'=>'ACTIONS', 'no-export'=>true, 'width'=>5]
];
   $data =[];
   foreach ($perceptions as $key=>$perception){

        $data[] =[
            $perception->created_at->format('Y-m-d H:i'),
            $perception->label,
            $perception->inscription?->eleve->fullName,
            $perception->inscription?->classe->code,
             Helpers::currencyFormat($perception->frais_montant) .' '.$perception->frais->devise->value,
             Helpers::currencyFormat($perception->montant) .' '. $perception->devise->value,
            ( (int)$perception->frais_montant-(int)($perception->montant)),
            $perception->user?->name,
            $perception,
];
   }

    $config =[
  'data'=>$data,
  'order'=>[[0, 'desc'],[3, 'asc'],[2, 'asc']],
  'columns'=>[null,null, null,null,null,null, null,null, null],
  'destroy'=>true,

];
@endphp
@section('title')
    Perceptions  {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Perceptions</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Factures et Perceptions</li>
            </ol>
        </div>
    </div>

@stop
<div>
    <div class="row g-2">
        @foreach ($this->boxes as $box)
            <div class="col-md-3" bis_skin_checked="1">
                <div class="info-box" bis_skin_checked="1">
                                    <span class="info-box-icon  bg-{{ $box['theme'] }} elevation-1">
                                        <i class="{{ $box['icon'] }}"></i></span>
                    <div class="info-box-content" bis_skin_checked="1">
                        <span class="info-box-text">{{ $box['text'] }}</span>
                        <span class="info-box-number">
                                            {{ $box['title'] }}
                                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">

                    </div>
                    <div class="card-tools d-flex my-auto">

                        @can('perceptions.create')
                            <a href="{{route('finance.caisse')}}" title="facturer un élève"
                               class="btn btn-primary  ml-2">
                                <i class="fas fa-plus"></i> Percevoir
                            </a>
                        @endcan
                        @can('perceptions.create')
                            <button onclick="showModal('finance.perception.import-perception-component')"
                                    title="facturer un élève"
                                    class="btn btn-success  ml-2">
                                <i class="fas fa-file-excel"></i> Import
                            </button>
                        @endcan
                    </div>
                </div>

                <div class="card-body m-b-40 table-responsive">
                    <x-adminlte-datatable wire:ignore.self head-theme="primary" theme="s" id="table1"
                                          :heads="$heads" striped
                                          hoverable with-buttons>
                        @foreach($config['data'] as $row)
                            <tr>
                                <td>{!! $row[0] !!}</td>
                                <td>{!! $row[1] !!}</td>
                                <td>{!! $row[2] !!}</td>
                                <td>{!! $row[3] !!}</td>

                                <td>{!! $row[4] !!}</td>

                                <td>{!! $row[5] !!}</td>
                                <td><span
                                        class="badge @if($row[6] > 0) badge-danger @else badge-success @endif">{!! Helpers::currencyFormat($row[6]) !!} {{$row[8]?->devise}}</span>
                                </td>
                                <td>{!! $row[7] !!}</td>
                                <td>
                                    <div class="d-flex float-right">
                                        @can('perceptions.update',$row[8])
                                            <a {{--href="{{route('finance.perceptions.edit', ['perception'=>$row[9]])}}--}}
                                               title="voir"
                                               class="btn btn-success btn-sm m-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        {{-- @can('perceptions.delete',$row[9])
                                             <button wire:click="getSelectedPerception('{{$row[9]}}')"
                                                     type="button"
                                                     title="Modifier" class="btn btn-danger btn-sm m-1"
                                                     data-toggle="modal"
                                                     data-target="#delete-perception">
                                                 <span class="fa fa-trash"></span>
                                             </button>
                                         @endcan--}}
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

