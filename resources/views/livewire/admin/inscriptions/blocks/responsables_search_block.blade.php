<div class="form-group">
    <div class="row mt-2 mb-2">
        <div class="form-group col-md-4 col-sm-12">

            <label for="" class="">Responsable :</label>
            <input type="text" class="form-control ml-2" wire:keydown.debounce="runSearch"
                   wire:model="searchResponsable" placeholder="Rechercher...">

        </div>
        <div class="form-group col-md-4 col-sm-12">
            <label for="">Nom Responsable Selectionné</label>
            <input type="text" readonly class="form-control" wire:model="responsable_nom">
        </div>
        <div @if($responsable_id == null) hidden @endif class="form-group col-md-4 col-sm-12">
            <label for="">Relation</label>
            <select wire:model="responsable_relation"
                    class="form-control">
                @foreach (\App\Enums\ResponsableRelation::cases() as $es )
                    <option value="{{$es->value}}">{{ $es->label() }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="">Choisir parmi {{ count($responsables) }} noms disponibles</label>
        <select wire:change.debounce="changeSelectedResponsable" wire:model="responsable_id"
                class="form-control">
            <option value="">Pas de choix...</option>
            @foreach ($responsables as $respo )
                <option value="{{$respo->id}}">{{ $respo->detail }}</option>
            @endforeach
        </select>
    </div>
</div>
