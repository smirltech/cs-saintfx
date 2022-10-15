@section('title')
    {{Str::upper('cenk')}} - ajouter filière
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Ajouter de filière</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.filieres') }}">Filières</a></li>
                <li class="breadcrumb-item active">Nouvelle Filière</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                    <x-validation-errors class="mb-4" :errors="$errors"/>
                    <form wire:submit.prevent="submit">
                        <div class="row">
                            <div class="form-group col-10">
                                <label for="">Nom <i class="text-red">*</i></label>
                                <input type="text" wire:model="nom" class="form-control  @error('nom') is-invalid @enderror">
                                @error('nom')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-2">
                                <label for="">Code <i class="text-red">*</i></label>
                                <input type="text" wire:model="code" class="form-control  @error('code') is-invalid @enderror">
                                @error('code')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <label for="">Section <i class="text-red">*</i></label>
                                <select wire:model="section_id"  wire:change="changeSection" class="form-control  @error('section_id') is-invalid @enderror">
                                    <option value="">Choisir section</option>
                                    @foreach ($sections as $section )
                                        <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                    @endforeach
                                    @error('section_id')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="">Option <i class="text-red">*</i></label>
                                <select wire:model="option_id" class="form-control  @error('option_id') is-invalid @enderror">
                                    <option value="">Choisir option</option>
                                    @foreach ($options as $option )
                                        <option value="{{ $option->id }}">{{ $option->nom }}</option>
                                    @endforeach

                                </select>
                                @error('option_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
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
