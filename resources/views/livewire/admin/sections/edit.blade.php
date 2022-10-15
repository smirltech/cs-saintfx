@section('title')
    {{Str::upper('cenk')}} - modifier section - {{$section->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Modifier section - {{$section->nom}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.sections') }}">Sections</a></li>
                <li class="breadcrumb-item active">{{$section->nom}}</li>
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
                                <input type="text" wire:keyup.debounce="genCode" wire:model="section.nom" class="form-control @error('section.nom') is-invalid @enderror">
                                @error('section.nom')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-2">
                                <label for="">Code <i class="text-red">*</i></label>
                                <input readonly type="text" wire:model="section.code" class="form-control @error('section.code') is-invalid @enderror">
                                @error('section.code')
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
