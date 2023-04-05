@php use App\Enums\ClasseGrade;use App\Models\Enseignant; @endphp
@section('title')
    - modifier classe - {{$classe->code}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Modifier classe - {{$classe->code}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.classes.index') }}">Classes</a></li>
                <li class="breadcrumb-item active">{{$classe->code}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                    <x-form::validation-errors hidden class="mb-4" :errors="$errors"/>
                    <form wire:submit.prevent="submit">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <x-form::select
                                    label="Niveau"
                                    required
                                    wire:model="grade">
                                    @foreach (ClasseGrade::cases() as $grade )
                                        <option value="{{ $grade->value}}">{{ $grade->label() }}</option>
                                    @endforeach
                                </x-form::select>
                            </div>
                            <div class="form-group col-md-6">
                                <x-form::input
                                    required
                                    type="text"
                                    label="Code"
                                    wire:model="code"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <x-form::select
                                    wire:model="section_id"
                                    label="Section"
                                    required>
                                    <option value="">Choisir section</option>
                                    @foreach ($sections as $section )
                                        <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                    @endforeach
                                </x-form::select>
                            </div>
                            <div class="form-group col-md-4">
                                <x-form::select
                                    refresh
                                    wire:model="option_id"
                                    label="Option"
                                    class="form-control">
                                    @foreach ($options as $option )
                                        <option value="{{ $option->id }}">{{ $option->nom }}</option>
                                    @endforeach
                                </x-form::select>

                            </div>
                            <div class="form-group col-md-4">
                                <x-form::select
                                    label="Filière"
                                    refresh
                                    wire:change="setCode"
                                    wire:model="filiere_id">
                                    @foreach ($filieres as $filiere )
                                        <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                    @endforeach
                                </x-form::select>
                            </div>
                            @if($classe->section?->primaire())
                                <div class="form-group col-md-4">
                                    <x-form::select
                                        wire:model="enseignant_id"
                                        label="Enseignant">
                                        @foreach(Enseignant::classe($classe)->get() as $c)
                                            <option value="{{ $c->id }}">{{ $c->nom }}</option>
                                        @endforeach
                                    </x-form::select>
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
