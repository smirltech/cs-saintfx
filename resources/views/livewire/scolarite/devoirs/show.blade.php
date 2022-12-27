@php use App\Enums\ClasseGrade;use Carbon\Carbon; @endphp
@section('title')
    {{$devoir->titre}}
@endsection
@section('content_header')
    <div hidden class="row mb-3">
        <div class="col-6">
            <h1 class="ms-3">{{$devoir->titre}}</h1>
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
    <div class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Devoir à domicile</h3>
                    </div>

                    <div class="card-body">
                        <strong><i class="fas fa-book-open mr-1"></i>Intitulé</strong>
                        <p class="text-muted">
                            {{$cours->nom}}
                            -
                            {{$devoir->titre}}
                        </p>
                        <hr>
                        <strong><i class="fas fa-clock mr-1"></i> Date limite</strong>
                        <p class="text-muted">
                            {{Carbon::parse($devoir->echeance)->format('d/m/Y H:i')}}
                            - {{$devoir->echeance_display}}

                        </p>
                        <hr>
                        <strong><i class="fas fa-school mr-1"></i>Classe</strong>
                        <p class="text-muted">{{$devoir->classe->code}}</p>
                        <hr>
                        @if($devoir->contenu)
                            <strong><i class="far fa-file-alt mr-1"></i>Contenu</strong>
                            <p class="text-muted">
                                {{$devoir->contenu}}
                            </p>
                            <hr>
                        @endif
                        @if($devoir->document)
                            <strong><i class="fas fa-file-pdf mr-1"></i>Pièce jointe</strong>
                            <p class="text-muted">
                            <ol class="list-group mt-3">
                                @foreach($devoir->media as $m)
                                    <li class="list-group-item">
                                        <a class="" title="Voir"
                                           href="{{route('media.show', $m)}}"
                                           target="_blank">{{$m->filename}}</a>
                                    </li>
                                @endforeach
                            </ol>
                            </p>
                        @endif

                    </div>

                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="submit">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <x-form-input required placeholder="Saisir le numéro de l'élève"
                                                  wire:model="matricule" type="number"
                                                  label="Matricule de l'élève"
                                                  :isValid="$errors->has('matricule') ? false : null"
                                                  error="{{$errors->first('matricule')}}"/>
                                </div>

                                <div class="form-group col-md-12">
                                    <x-form-textarea
                                        required
                                        placeholder="Saisir le contenu du devoir"
                                        wire:model.defer="devoir.contenu"
                                        label="Contenu du devoir"
                                        rows="10"
                                        :isValid="$errors->has('devoir.contenu') ? false : null"
                                        error="{{$errors->first('devoir.contenu')}}"/>
                                </div>

                                <div class="form-group col-md-12">
                                    <x-form-file-pdf wire:model="document"
                                                     label="Document du devoir"
                                                     target="document"
                                                     :isValid="$errors->has('document') ? false : null"
                                                     error="{{$errors->first('document')}}"/>
                                    <ol class="list-group mt-3">
                                        @foreach($devoir->media as $m)
                                            <li class="list-group-item">
                                                <a class="" title="Voir"
                                                   href="{{route('media.show', $m)}}"
                                                   target="_blank">{{$m->filename}}</a>
                                                |
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i wire:click="deleteMedia('{{$m->id}}')"
                                                       class="fa fa-minus"></i>
                                                </button>

                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                            <x-button class="btn-primary float-end">Soumettre</x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

