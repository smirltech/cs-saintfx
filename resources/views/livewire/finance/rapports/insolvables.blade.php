@php use App\Enums\FraisType;use App\Models\Perception;use Carbon\Carbon; use App\Enums\MinervalMonth; @endphp
@section('title')
    CENK - Papports
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Insolvables / En ordres</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Insolvables / En ordres</li>
            </ol>
        </div>
    </div>

@stop
<div class="container-fluid">
    <form wire:submit.prevent="search" class="mt-1">
        <div class="row">
            <div class="col-md-3">
                <x-form::select
                    placeholder="Section"
                    wire:model="section_id"
                    :options="$sections"/>
            </div>
            <div class="col-md-3">
                <x-form::select
                    placeholder="Classe"
                    wire:model="classe_id"
                    :options="$classes"/>
            </div>
            <div class="col-md-3">
                <x-form::select
                    placeholder="Frais"
                    wire:model="frais_id"
                    :options="$fraisOptions"/>
            </div>
            <div class="col-md-3">
                <x-form::select
                        placeholder="Mois"
                        change
                        wire:model="month"
                        :options="MinervalMonth::cases()"/>
            </div>


            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div style="display: flex;" class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="date_from">Debut : </span>
                            </div>
                            <input aria-label="date_from" aria-describedby="date_from" max="{{$date_to}}"
                                   placeholder="date debut" type="date" wire:model="date_from"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="display: flex;" class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="date_to">Fin : </span>
                            </div>
                            <input max="{{Carbon::now()->endOfDay()->format('Y-m-d')}}"
                                   min="{{$date_from}}"
                                   aria-label="date_to" aria-describedby="date_to"
                                   placeholder="date fin"
                                   type="date" wire:model="date_to"
                                   class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
    <div class="card">
        <div class="card-body">
            @include('livewire.finance.rapports.modals.insolvables-printable')
        </div>
        <div class="card-footer text-center">
            <button wire:click="printIt" class="btn btn-primary text-center">
                <i class="fa fa-file-pdf"></i>
                Télécharger</button>
        </div>
    </div>
</div>
