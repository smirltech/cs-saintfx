@php use App\Enums\ClasseGrade; @endphp
@section('title')
    Création d'un devoir
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Création d'un devoir</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.devoirs.index') }}">Devoirs</a></li>
                <li class="breadcrumb-item active">{{$devoir->titre}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    <div class="content mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="submit">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <x-form-input placeholder="Saisir l'intitulé du devoir"
                                                  wire:model.defer="devoir.titre"
                                                  label="Intitulé du devoir"
                                                  :isValid="$errors->has('devoir.titre') ? false : null"
                                                  error="{{$errors->first('devoir.titre')}}"/>
                                </div>

                                <div class="form-group col-md-4">
                                    <x-form-select wire:model.defer="devoir.classe_id"
                                                   label="Classe"
                                                   :isValid="$errors->has('devoir.classe_id') ? false : null"
                                                   error="{{$errors->first('devoir.classe_id')}}">
                                        @foreach($classes as $classe)
                                            <option value="{{$classe->id}}">{{$classe->code}}</option>
                                        @endforeach
                                    </x-form-select>
                                </div>

                                <div class="form-group col-md-4">
                                    <x-form-select wire:model.defer="devoir.cours_id"
                                                   label="Cours"
                                                   :isValid="$errors->has('devoir.cours_id') ? false : null"
                                                   error="{{$errors->first('devoir.cours_id')}}">
                                        @foreach($cours as $c)
                                            <option value="{{$c->id}}">{{$c->nom}}</option>
                                        @endforeach
                                    </x-form-select>
                                </div>

                                <div class="form-group col-md-4">
                                    <x-form-input min="{{date('Y-m-d')}}" wire:model.defer="devoir.echeance"
                                                  label="Date limite de dépôt"
                                                  :isValid="$errors->has('devoir.echeance') ? false : null"
                                                  error="{{$errors->first('devoir.echeance')}}" type="date"/>
                                </div>


                                <div class="form-group col-md-12">
                                    <x-form-textarea
                                        placeholder="Saisir le contenu du devoir"
                                        wire:model.defer="devoir.description"
                                        label="Contenu du devoir"
                                        ckeditor="basic"
                                        :isValid="$errors->has('devoir.contenu') ? false : null"
                                        error="{{$errors->first('devoir.contenu')}}"/>


                                </div>

                                <div class="form-group col-md-12">
                                    <x-form-file wire:model.defer="document"
                                                 label="Document du devoir"
                                                 :isValid="$errors->has('document') ? false : null"
                                                 error="{{$errors->first('document')}}"/>
                                    <ul class="list-group mt-3">
                                        @foreach($documents as $m)
                                            <li class="list-group-item">
                                                <a title="Voir" href="{{route('media.show', $m)}}"
                                                   target="_blank">{{$m->filename}}</a>
                                                | <i wire:click="deleteMedia('{{$m->id}}')" class="fa fa-trash"></i>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-end">Soumettre</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

