@php use App\Enum\PromotionGrade; @endphp
<div class="">


    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <div class="row">
                            <div class="form-group col">
                                <label for="">Grade</label>
                                <select wire:change="setCode" wire:model="grade"
                                        class="form-control  @error('grade') is-invalid @enderror">
                                    <option value="">Choisir grade</option>
                                    @foreach (PromotionGrade::cases() as $grade )
                                        <option value="{{ $grade->value}}">{{ $grade->label() }}</option>
                                    @endforeach
                                    @error('grade')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="">Code</label>
                                <input readonly type="text" wire:model="code"
                                       class="form-control  @error('code') is-invalid @enderror">
                                @error('code')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Doyen</label>
                            <select wire:change="setCode" wire:model="filiere_id"
                                    class="form-control  @error('filiere_id') is-invalid @enderror">
                                <option value="-1">Choisir filière</option>
                                @foreach ($filieres as $filiere )
                                    <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                @endforeach
                                @error('filiere_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
