@php use App\Models\Perception; @endphp
@section('title')
    {{Str::upper(env('APP_NAME', 'cenk finance'))}} - Élèves  {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste d'élèves</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance.finance') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Élèves</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @php
        $heads =[
            ['label'=>'CODE', 'width'=>8],
            'ELEVE',
            'SEXE',
            'CATEGORIE',
            'CLASSE',
            'MONTANT DÛ',

            ['label'=>'', 'no-export'=>true, 'width'=>5]
    ];
       $data =[];
       foreach ($inscriptions as $inscription){
           $perceptionsRequest = Perception::where('annee_id', $annee_id)->where('inscription_id', $inscription->id);
            $perceptions = $perceptionsRequest->get();
        $perceptionsDues = $perceptionsRequest->sum("montant");
        $perceptionsPaid = $perceptionsRequest->sum("paid");

            $data[] =[
                $inscription->code,
                "{$inscription->eleve->nom} {$inscription->eleve->postnom} {$inscription->eleve->prenom}",
                "{$inscription->eleve->sexe->value}",
                $inscription->categorie->label(),
                $inscription->classe->code,
                ($perceptionsDues - $perceptionsPaid),
                $inscription->id,
    ];
       }

        $config =[
      'data'=>$data,
      'order'=>[[1, 'asc']],
      'columns'=>[null,null,null,null, null, ['orderable'=>false]],
      'destroy'=>true,

    ];
    @endphp
    {{-- @include('livewire.finance.eleves.modals.crud')--}}

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
                                        data-target="#add-perception-modal"><span
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
                                        <td><span
                                                class="@if($row[5] > 0) badge badge-danger @endif">{!! Helpers::currencyFormat($row[5], symbol: 'Fc') !!}</span>
                                        </td>

                                        <td>
                                            <div class="d-flex float-right">
                                                <a href="/finance/eleves/{{ $row[6] }}" title="voir"
                                                   class="btn btn-success  ml-2">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                {{--<button wire:click="getSelectedPerception({{$row[6]}})" type="button"
                                                        title="Modifier" class="btn btn-success  ml-2" data-toggle="modal"
                                                        data-target="#edit-perception-modal">
                                                    <span class="fa fa-eye"></span>
                                                </button>--}}
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

