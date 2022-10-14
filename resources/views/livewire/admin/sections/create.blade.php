<div class="">

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                     <form wire:submit.prevent="submit">
                <div class="row">
                    <div class="form-group col-10">
                        <label for="">Nom <i class="text-red">*</i></label>
                        <input type="text" wire:model="nom" class="form-control @error('nom') is-invalid @enderror">
                        @error('nom')
                            <span class="text-red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-2">
                        <label for="">Code <i class="text-red">*</i></label>
                        <input type="text" wire:model="code" class="form-control @error('code') is-invalid @enderror">
                        @error('code')
                        <span class="text-red">{{ $message }}</span>
                    @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Soumettre</button>
            </form>
                </div>
            </div>

        </div>
    </div>
</div>
