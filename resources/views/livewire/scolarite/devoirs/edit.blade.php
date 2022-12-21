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
                <li class="breadcrumb-item"><a href="{{ route('scolarite.devoirs.index') }}">Devoirs</a></li>
                <li class="breadcrumb-item active">{{$devoir->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    <div class="content mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Devoir
                    </div>
                    <div class="card-body">
                        <x-validation-errors class="mb-4" :errors="$errors"/>
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
                                    <x-form-textarea
                                        placeholder="Saisir le contenu du devoir"
                                        wire:model="devoir.description"
                                        label="Contenu du devoir"
                                        ckeditor="basic"
                                        :isValid="$errors->has('devoir.contenu') ? false : null"
                                        error="{{$errors->first('devoir.contenu')}}"/>


                                </div>

                                <div class="form-group col-md-12">
                                    <x-form-file wire:model="document"
                                                 label="Document du devoir"
                                                 :isValid="$errors->has('document') ? false : null"
                                                 error="{{$errors->first('document')}}"/>
                                    <ul class="list-group mt-3">
                                        @foreach($devoir->media as $m)
                                            <li class="list-group-item">
                                                <a title="Voir" href="{{route('media.show', $m)}}"
                                                   target="_blank">{{$m->filename}}</a>
                                                | <i wire:click="deleteModel({{$m}})" class="fa fa-trash"></i>
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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Reponses
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>ELEVE</th>
                                <th>DATE</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($reponses as $k=>$reponse)
                                <tr>
                                    <td>
                                        <x-avatar src="{{$reponse->eleve->avatar}}"/>
                                    </td>
                                    <td>
                                        {{ $reponse->eleve->nom_complet }}
                                    </td>
                                    <td>{{ $reponse->created_at_display }}</td>
                                    <td>
                                        {{ $reponse->status?->label() }}
                                    </td>

                                    <td>
                                        <div class="d-flex float-right">
                                            @if($reponse->document)
                                                <a href="{{route('media.show', $reponse->document)}}"
                                                   title=" Document"
                                                   class="btn btn-outline-primary  ml-2">
                                                    <i class="fas fa-file"></i>
                                                </a>
                                            @endif
                                            <a href="{{route('scolarite.devoirs.edit',$reponse )}}"
                                               title="modifier"
                                               class="btn btn-outline-info  ml-2">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

