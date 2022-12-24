@php
    use App\Enums\ResultatType;
@endphp

<div>
   {{-- @include('livewire.scolarite.resultats.blocks.modals.result')--}}
  {{--  @include('livewire.scolarite.resultats.blocks.modals.printable')--}}
    <div class="input-group  mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Résultats </span>
        </div>
     <div>dddd</div>
        <div class="input-group-append ml-1" id="button-addon4">
            <button wire:click="printIt" title="Imprimer résultats" class="btn btn-outline-secondary" type="button"><i
                    class="fas fa-print"></i></button>
        </div>
    </div>

    <div class="card-body p-0 table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th></th>
                <th>ÉLÈVE</th>

                <th>CONDUITE</th>

            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
