<div class="">


    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <div class="row">
                            <div class="form-group col-10">
                                <label for="">Nom</label>
                                <input type="text" wire:model="nom" class="form-control  @error('nom') is-invalid @enderror">
                                @error('nom')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-2">
                                <label for="">Code</label>
                                <input type="text" wire:model="code" class="form-control  @error('code') is-invalid @enderror">
                                @error('code')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Faculté</label>
                            <select wire:model="faculte_id" class="form-control  @error('faculte_id') is-invalid @enderror">
                                <option value="-1">Choisir faculté</option>
                                @foreach ($facultes as $faculte )
                                <option value="{{ $faculte->id }}">{{ $faculte->nom }}</option>
                                @endforeach
                                @error('faculte_id')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea wire:model="description" rows="5" class="form-control  @error('description') is-invalid @enderror"></textarea>
                            @error('description')
                            <span class="text-red">{{ $message }}</span>
                        @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
