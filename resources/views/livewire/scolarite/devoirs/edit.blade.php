@php use App\Enums\ClasseGrade; @endphp
@section('title')
    {{$devoir->titre}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">{{$devoir->titre}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.devoirs.index') }}">Cours</a></li>
                <li class="breadcrumb-item active">{{$devoir->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    {{--  <x-validation-errors class="mb-4" :errors="$errors"/>--}}
                    <form wire:submit.prevent="submit">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <x-form-input placeholder="Saisir l'intitulé du devoir"
                                              wire:model="devoir.titre"
                                              label="Intitulé du devoir"
                                              :isValid="$errors->has('devoir.titre') ? false : null"
                                              error="{{$errors->first('devoir.titre')}}"/>
                            </div>

                            <div class="form-group col-md-6">
                                <x-form-select wire:model="devoir.classe_id"
                                               label="Classe"
                                               :isValid="$errors->has('devoir.classe_id') ? false : null"
                                               error="{{$errors->first('devoir.classe_id')}}">
                                    @foreach($classes as $classe)
                                        <option value="{{$classe->id}}">{{$classe->code}}</option>
                                    @endforeach
                                </x-form-select>
                            </div>

                            <div class="form-group col-md-6">
                                <x-form-select wire:model="devoir.cours_id"
                                               label="Cours"
                                               :isValid="$errors->has('devoir.cours_id') ? false : null"
                                               error="{{$errors->first('devoir.cours_id')}}">
                                    @foreach($cours as $c)
                                        <option value="{{$c->id}}">{{$c->nom}}</option>
                                    @endforeach
                                </x-form-select>
                            </div>


                            <div class="form-group col-md-12">
                                <x-form-textarea rows="5"
                                                 placeholder="Saisir la description du cours"
                                                 wire:model="devoir.description"
                                                 label="Description du cours"
                                                 :isValid="$errors->has('devoir.description') ? false : null"
                                                 error="{{$errors->first('devoir.description')}}"/>


                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
