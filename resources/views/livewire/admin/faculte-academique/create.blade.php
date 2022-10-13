<div class="">

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                     <form wire:submit.prevent="submit">
                <div class="row">
                    <div class="form-group col-10">
                        <label for="">Nom</label>
                        <input type="text" wire:model="nom" class="form-control">
                        @error('nom')
                            <span class="text-red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-2">
                        <label for="">Code</label>
                        <input type="text" wire:model="code" class="form-control">
                        @error('code')
                        <span class="text-red">{{ $message }}</span>
                    @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="">Email</label>
                        <input type="email" wire:model="email" class="form-control">

                    </div>
                    <div class="form-group col-4">
                        <label for="">Phone</label>
                        <input type="tel" wire:model="phone" class="form-control">
                    </div>
                    <div class="form-group col-4">
                        <label for="">Coordonnées</label>
                        <input type="text" wire:model="latlng" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Doyen</label>
                    <input type="text" wire:model="doyen" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <textarea wire:model="description" rows="5" class="form-control"></textarea>

                </div>

                <button type="submit" class="btn btn-primary">Soumettre</button>
            </form>
                </div>
            </div>

        </div>
    </div>
</div>
