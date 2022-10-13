<div class="">


    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <div class="row">
                            <div class="form-group col-10">
                                <label for="">Nom</label>
                                <input type="text" wire:model="filiere.nom" class="form-control  @error('filiere.nom') is-invalid @enderror">
                                @error('filiere.nom')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-2">
                                <label for="">Code</label>
                                <input type="text" wire:model="filiere.code" class="form-control  @error('filiere.code') is-invalid @enderror">
                                @error('filiere.code')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Faculté</label>
                            <select wire:model="filiere.faculte_id" class="form-control  @error('filiere.faculte_id') is-invalid @enderror">
                                <option value="-1">Choisir faculté</option>
                                @foreach ($facultes as $faculte )
                                <option value="{{ $faculte->id }}">{{ $faculte->nom }}</option>
                                @endforeach
                                @error('filiere.faculte_id')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea wire:model="filiere.description" rows="5" class="form-control  @error('filiere.description') is-invalid @enderror"></textarea>
                            @error('filiere.description')
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
