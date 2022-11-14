@php use App\Enums\ClasseGrade; @endphp
@section('title')
    {{Str::upper('cenk')}} - modifier classe - {{$cours->code}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Modifier classe - {{$cours->code}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cours.index') }}">Classes</a></li>
                <li class="breadcrumb-item active">{{$cours->code}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                {{$cours}}
                <div class="card-body">
                    <x-validation-errors class="mb-4" :errors="$errors"/>
                    <form wire:submit.prevent="submit">
                        <div class="row">
                            <div class="form-group col">
                                <label for="">Code <i class="text-red">*</i></label>
                                <input type="text" readonly wire:model="cours.code"
                                       class="form-control  @error('cours.code') is-invalid @enderror">
                                @error('cours.code')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col">
                                <label for="">Nom <i class="text-red">*</i></label>
                                <input type="text" wire:model="cours.nom"
                                       class="form-control  @error('cours.nom') is-invalid @enderror">
                                @error('cours.nom')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col">
                                <label for="">Nom <i class="text-red">*</i></label>
                                <input type="text" wire:model="cours.description"
                                       class="form-control  @error('cours.nom') is-invalid @enderror">
                                @error('cours.description')
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
