@php use App\Enums\Devise; @endphp
<x-modals::form title="Ajouter un frais">
    <div class="row">
        <div class="col-md-6">
            <x-form::input
                required
                label="Nom"
                wire:model="frais.nom"/>
        </div>
        <div class="col-md-6">
            <x-form::input-money
                :currency="Devise::USD"
                required
                type="number"
                label="Montant"
                wire:model="frais.montant"/>
        </div>

        <div class="col-sm-12">
            <x-form::textarea
                label="Description"
                rows="2"
                wire:model="frais.description"/>
        </div>
    </div>
</x-modals::form>
