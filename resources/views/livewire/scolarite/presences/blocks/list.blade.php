@php
    use App\Enums\ResultatType;
@endphp

<div>
   {{-- @include('livewire.scolarite.resultats.blocks.modals.result')--}}
  {{--  @include('livewire.scolarite.resultats.blocks.modals.printable')--}}
    <div class="input-group  mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Date : </span>
        </div>

            <input type="date" wire:model="current_date"
                   class="form-control">

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
                <th>ÉTAT</th>
                <th>OBSERVATION</th>
                <th>ACTIONS</th>

            </tr>
            </thead>
            <tbody>

                @foreach($presences as $i=>$presence)

                    <tr>
                        <td>{{$i+1}}</td>
                        <td>
                            <a href="{{route('scolarite.eleves.show', [$presence->inscription?->eleve])}}">{{$presence->inscription->eleve?->fullName}}</a>
                        </td>
                        <td >{{$presence->status->label()}}</td>
                        <td>{{$presence->observation}}</td>
                        <td>
                            <div class="d-flex float-right">
                                {{--<button wire:click="selectInscription('{{$inscription->id }}')"
                                        title="supprimer"
                                        class="btn btn-sm btn-outline-warning ml-2"
                                        data-toggle="modal"
                                        data-target="#update-resultat">
                                    <i class="fas fa-edit"></i>
                                </button>--}}
                            </div>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
