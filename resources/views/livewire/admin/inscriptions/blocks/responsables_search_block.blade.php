<div class="form-group">
    <div class="row mt-2 mb-2">
        <div class="form-group col-md-4 col-sm-12">

                <label for="" class="">Responsable :</label>
                <input type="text" class="form-control ml-2" wire:keydown.debounce="runSearch" wire:model="searchResponsable" placeholder="Rechercher...">

        </div>
        <div class="form-group col-md-4 col-sm-12">
            <label for="">Nom Responsable</label>
            <input type="text" readonly class="form-control" wire:model="responsable_nom">
        </div>
        <div class="form-group col-md-4 col-sm-12">
            <label for="">Relation</label>
            <select wire:model="responsable_relation"
                    class="form-control">
                @foreach (\App\Enum\ResponsableRelation::cases() as $es )
                    <option value="{{$es->value}}">{{ $es->label() }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <select wire:change.debounce="changeSelectedResponsable" wire:model="responsable_id"
            class="form-control">
        <option value="">Choisir parmi {{ count($responsables) }} noms...</option>
        @foreach ($responsables as $respo )
            <option value="{{$respo->id}}">{{ $respo->nom }}</option>
        @endforeach
    </select>
</div>
