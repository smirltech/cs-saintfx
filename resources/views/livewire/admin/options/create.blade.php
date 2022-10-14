<div class="">

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                     <form wire:submit.prevent="submit">
                <div class="row">
                    <div class="form-group col-5">
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
                    <div class="form-group col-5">
                        <label for="">Section</label>
                        <select wire:model="section_id" class="form-control  @error('section_id') is-invalid @enderror">
                            <option value="-1">Choisir section</option>
                            @foreach ($sections as $section )
                                <option value="{{ $section->id }}">{{ $section->nom }}</option>
                            @endforeach
                            @error('section_id')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Soumettre</button>
            </form>
                </div>
            </div>

        </div>
    </div>
</div>
