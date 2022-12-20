@php use Carbon\Carbon; @endphp
@section('title')
    {{Str::upper('cenk')}} - rapports
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Rapports Financiers</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Rapports Financiers</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div id="factPrint" class="card">

                        <div class="card-header">
                            <div style="text-align: center;" class="card-title justify-content-center">
                                CENK FINANCE - {{$anneeNom}}
                            </div>
                            <br>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div style="display: flex; width: 100%" class="card-header">
                                    <div style="flex: 55%;" class="card-title">
                                        <div>Rapport financier de la période</div>
                                    </div>
                                    <div style="flex: 45%; float: right; position: relative"
                                         class="card-tools d-flex my-auto">
                                        <div style="display: flex;" class="row mt-1 mb-1">
                                            <div style="flex: 50%;" class="col-sm-6">
                                                <div style="display: flex;" class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="ddebut">Debut : </span>
                                                    </div>
                                                    <input aria-label="ddebut" aria-describedby="ddebut" max="{{$dfin}}"
                                                           placeholder="date debut" type="date" wire:model="ddebut"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div style="flex: 50%;" class="col-sm-6">
                                                <div style="display: flex;" class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="dfin">Fin : </span>
                                                    </div>
                                                    <input max="{{Carbon::now()->endOfDay()->format('Y-m-d')}}"
                                                           min="{{$ddebut}}"
                                                           aria-label="dfin" aria-describedby="dfin"
                                                           placeholder="date fin"
                                                           type="date" wire:model="dfin"
                                                           class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body m-b-40">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>Entrées</h4>
                                            <hr>
                                            <ul class="list-group">
                                                @if($revenuAuxiliaire != 0)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        Revenu Auxiliaire
                                                        <span style="float: right"
                                                              class="">{{number_format($revenuAuxiliaire)}} Fc</span>
                                                    </li>
                                                @endif
                                                @if($perception != 0)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        Perceptions
                                                        <span style="float: right"
                                                              class="">{{number_format($perception)}} Fc</span>
                                                    </li>
                                                    <ul class="list-group">
                                                        @foreach($frais as $k=>$fee)
                                                            @if($fee > 0)
                                                                <li class="pl-5 pr-5 list-group-item d-flex justify-content-between align-items-center font-italic">
                                                                    {{$k}}
                                                                    <span style="float: right; padding-right: 25px"
                                                                          class=""><i>{{number_format($fee)}} Fc</i></span>
                                                                </li>
                                                            @endif

                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>Sorties</h4>
                                            <hr>
                                            <ul class="list-group">
                                                @if($depenses != 0)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        Dépenses
                                                        <span style="float: right"
                                                              class="">{{number_format($depenses)}} Fc</span>
                                                    </li>
                                                    <ul class="list-group">
                                                        @foreach($categories as $k=>$category)
                                                            @if($category > 0)
                                                                <li class="pl-5 pr-5 list-group-item d-flex justify-content-between align-items-center font-italic">
                                                                    {{$k}}
                                                                    <span style="float: right;padding-right: 25px"
                                                                          class=""><i>{{number_format($category)}} Fc</i></span>
                                                                </li>
                                                            @endif

                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button wire:click="printIt" class="btn btn-primary">Imprimer</button>
                </div>

            </div>
        </div>
    </div>
</div>

