@php use App\Enums\FraisType; @endphp
@php use App\Enums\MinervalType; @endphp
<x-modals::form title="Perception de {{$inscription->eleve->nom}}">
    <div class="row">

        <div wire:ignore class="form-group col-md-12">
            <label for="">Frais</label>
            <x-form::select required wire:change="feeSelected" wire:model="perception.frais_id"
                            class="form-control">
                @foreach ($frais as $feee )
                    <option value="{{$feee->id}}">{{ $feee->label }}</option>
                @endforeach
            </x-form::select>
        </div>
        <div class="form-group col-md-6">
            <label for="">Montant à Payer (Fc) <i class="text-red">*</i></label>
            <input disabled type="number" wire:model="perception.frais_montant"
                   class="form-control @error('montant') is-invalid @enderror">
            @error('montant')
            <span class="text-red">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group  col-md-6">
            <label for="">Montant Payé</label>
            <input required type="number" wire:model="perception.montant"
                   class="form-control">
        </div>
        <div class="form-group col-md-12">
            <label for="">Payé Par</label>
            <input type="text" wire:model="perception.paid_by"
                   class="form-control">
        </div>
    </div>
</x-modals::form>

