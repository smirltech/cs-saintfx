@php use App\Enums\FraisType; @endphp
@php use App\Enums\MinervalMonth; @endphp
<x-modals::form title="Perception de {{$inscription->eleve->nom}}">
    <div class="row mb-3">
        <div class="col-md-12">
            <x-form::select
                label="Frais"
                required wire:change="feeSelected" wire:model="perception.frais_id"
                            class="form-control">
                @foreach ($frais as $feee )
                    <option value="{{$feee->id}}">{{ $feee->label }}</option>
                @endforeach
            </x-form::select>
        </div>
        @if($fee?->type?->properties())
            <div class="col-md-12">
                <x-form::select :change='true' label="{{ __('Mois') }}" class="form-select"
                                :options="$fee?->type?->properties()" wire:model="perception.custom_property"/>
            </div>
        @endif
        <div class="col-md-6">
            <label for="">Montant à Payer (Fc) <i class="text-red">*</i></label>
            <input disabled type="number" wire:model="perception.frais_montant"
                   class="form-control @error('montant') is-invalid @enderror">
            @error('montant')
            <span class="text-red">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="">Montant Payé</label>
            <input required type="number" wire:model="perception.montant"
                   class="form-control">
        </div>
        <div class="col-md-12">
            <label for="">Payé Par</label>
            <input type="text" wire:model="perception.paid_by"
                   class="form-control">
        </div>
    </div>
</x-modals::form>

