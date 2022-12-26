@php use App\Enums\FraisType; @endphp
@php use App\Enums\FraisFrequence; @endphp

@section('title')
    {{Str::upper(env('APP_NAME', 'cenk finance'))}} - Modifier Facture  {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Modifier Facture</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('finance.perceptions') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('finance.perceptions') }}">Perceptions</a></li>
                <li class="breadcrumb-item active">Modifier Facture</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    @include('livewire.finance.cards.recu')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Élève : <strong>{{$eleveNom}}</strong></h4>
                            <div class="card-tools">
                                <button title="Supprimer" role="button" class="btn"
                                ><span aria-hidden="true">&times;</span></button>
                            </div>
                        </div>
                        <div class="card-body m-b-40">
                            <x-validation-errors class="mb-4" :errors="$errors"/>
                            <form id="f1" wire:submit.prevent="editPerception">

                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="">Frais</label>
                                        <select wire:ignore.self wire:change="feeSelected" wire:model="fee_id"
                                                class="form-control">
                                            <option value="">Choisir frais... !</option>
                                            @foreach ($frais as $feee )
                                                <option value="{{$feee->id}}">{{ $feee->nom }}
                                                    [{{ $feee->type->label() }}]
                                                    [{{ $feee->frequence->label() }}]
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="">Raison</label>
                                        <select wire:model="custom_property"
                                                class="form-control">
                                            <option value="">Choisir raison... !</option>
                                            @foreach ($raisons as $raison )
                                                <option value="{{$raison}}">{{$raison}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="">Echéance <i class="text-red">*</i></label>
                                        <input type="date" wire:model="due_date"
                                               class="form-control @error('due_date') is-invalid @enderror">
                                        @error('due_date')
                                        <span class="text-red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="">Montant à Payer <i class="text-red">*</i></label>
                                        <input type="number" wire:model="montant"
                                               class="form-control @error('montant') is-invalid @enderror">
                                        @error('montant')
                                        <span class="text-red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="">Montant Payé</label>
                                        <input type="number" wire:model="paid"
                                               class="form-control">
                                    </div>
                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="">Payé Par</label>
                                        <input type="text" wire:model="paid_by"
                                               class="form-control">
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="card-footer ">
                            <div class="d-flex justify-content-between">
                                <button form="f1" type="submit" class="btn btn-primary">Valider</button>
                                {{--<button type="button" class="btn btn-success"
                                        data-toggle="modal"
                                        data-target="#recu-modal">
                                    Valider et Imprimer
                                </button>--}}
                                <button wire:click="printIt" type="button" class="btn btn-success">Valider et Imprimer
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

