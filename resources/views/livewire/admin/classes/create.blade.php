@php use App\Enums\ClasseGrade; @endphp
@section('title')
    {{Str::upper('cenk')}} - ajouter classe
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Ajouter de classe</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.classes') }}">Classes</a></li>
                <li class="breadcrumb-item active">Nouvelle Classe</li>
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
                            <div class="form-group col">
                                <label for="">Grade <i class="text-red">*</i></label>
                                <select wire:change="setCode" wire:model="grade"
                                        class="form-control  @error('grade') is-invalid @enderror">
                                    <option value="">Choisir grade</option>
                                    @foreach (ClasseGrade::cases() as $grade )
                                        <option value="{{ $grade->value}}">{{ $grade->label() }}</option>
                                    @endforeach
                                </select>
                                @error('grade')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col">
                                <label for="">Code <i class="text-red">*</i></label>
                                <input type="text" readonly wire:model="code"
                                       class="form-control  @error('code') is-invalid @enderror">
                                @error('code')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="">Section <i class="text-red">*</i></label>
                                <select wire:model="section_id" wire:change="changeSection"
                                        class="form-control  @error('section_id') is-invalid @enderror">
                                    <option value="">Choisir section</option>
                                    @foreach ($sections as $section )
                                        <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                    @endforeach
                                    @error('section_id')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="">Option</label>
                                <select wire:model="option_id" wire:change="changeOption" class="form-control">
                                    <option value="">Choisir option</option>
                                    @foreach ($options as $option )
                                        <option value="{{ $option->id }}">{{ $option->nom }}</option>
                                    @endforeach

                                </select>

                            </div>
                            <div class="form-group col-4">
                                <label for="">Filière</label>
                                <select wire:change="setCode" wire:model="filiere_id"
                                        class="form-control">
                                    <option value="">Choisir filière</option>
                                    @foreach ($filieres as $filiere )
                                        <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                    @endforeach

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
