@section('title')
    {{Str::upper('cenk')}} - modifier option - {{$option->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Modifier option - {{$option->nom}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.options') }}">Options</a></li>
                <li class="breadcrumb-item active">{{$option->nom}}</li>
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
                            <div class="form-group col-5">
                                <label for="">Nom <i class="text-red">*</i></label>
                                <input type="text" wire:model="option.nom" class="form-control @error('option.nom') is-invalid @enderror">
                                @error('option.nom')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-2">
                                <label for="">Code <i class="text-red">*</i></label>
                                <input type="text" wire:model="option.code" class="form-control @error('option.code') is-invalid @enderror">
                                @error('option.code')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-5">
                                <label for="">Section <i class="text-red">*</i></label>
                                <select wire:model="option.section_id" class="form-control  @error('option.section_id') is-invalid @enderror">
                                    <option value="-1">Choisir section</option>
                                    @foreach ($sections as $section )
                                        <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                    @endforeach
                                    @error('option.section_id')
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
