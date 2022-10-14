<div class="">

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                    <form wire:submit.prevent="submit">
                <div class="row">
                    <div class="form-group col-10">
                        <label for="">Nom</label>
                        <input type="text" wire:model="faculte.nom" class="form-control @error('faculte.nom') is-invalid @enderror">
                        @error('faculte.nom')
                            <span class="text-red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-2">
                        <label for="">Code</label>
                        <input type="text" wire:model="faculte.code" class="form-control @error('faculte.code') is-invalid @enderror"">
                        @error('faculte.code')
                        <span class="text-red">{{ $message }}</span>
                    @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="">Email</label>
                        <input type="email" wire:model="faculte.email" class="form-control  @error('faculte.email') is-invalid @enderror"">
                        @error('faculte.email')
                        <span class="text-red">{{ $message }}</span>
                    @enderror
                    </div>
                    <div class="form-group col-4">
                        <label for="">Phone</label>
                        <input type="tel" wire:model="faculte.phone" class="form-control">
                    </div>
                    <div class="form-group col-4">
                        <label for="">Coordonnées</label>
                        <input type="text" wire:model="faculte.latlng" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Doyen</label>
                    <input type="text" wire:model="faculte.doyen" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <textarea wire:model="faculte.description" rows="5" class="form-control"></textarea>

                </div>

                <button type="submit" class="btn btn-primary">Soumettre</button>
            </form>
                </div>
            </div>

        </div>
    </div>
</div>
