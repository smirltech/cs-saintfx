@php use Carbon\Carbon; @endphp
@section('title')
     - rapports
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
            <div style="display: flex; width: 100%" class="card-header justify-content-end">
                <div class="card-tools d-flex my-auto">
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
            <div class="row">
                <div class="col-md-12">
                    @include('livewire.finance.rapports.modals.printable')
                </div>
                <div class="col-md-12">
                    <button wire:click="printIt" class="btn btn-primary">Imprimer</button>
                </div>

            </div>
        </div>
    </div>
</div>

