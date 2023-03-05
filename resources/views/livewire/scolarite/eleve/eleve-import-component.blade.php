@php use App\Models\Annee; @endphp
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">{{$title}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{route('scolarite.inscriptions.index')}}">Déliberations</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="content mt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="mb-3 card-body">
                        <form wire:submit.prevent="submit" class="container">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <x-form::select label="Année" required placeholder="Choisir année scolaire"
                                                    wire:model="annee">
                                        @foreach($annees as $annee)
                                            <option value="{{$annee->id}}">{{$annee->nom}}
                                            </option>
                                        @endforeach
                                    </x-form::select>
                                </div>

                                <div class="form-group col-md-6">
                                    {{--                                    @json($classes)--}}
                                    <x-form::select
                                        label="Classe"
                                        required
                                        placeholder="Choisir classe"
                                        wire:model="classe">
                                        @foreach($classes as $classe)
                                            <option value="{{$classe->id}}">{{$classe->nom}}
                                            </option>
                                        @endforeach
                                    </x-form::select>
                                </div>


                                <div class="form-group col-md-12">

                                    <x-form::input-xlsx required label="Fiche d identification"
                                                        wire:model="file"/>
                                    <div class="mt-2">
                                        Veuillez télécharger le modèle de la fiche d'identification <a
                                            href="{{asset("models/FICHE D'IDENTIFICATION CENK.xlsx")}}">ici</a>
                                    </div>
                                </div>
                            </div>
                            <x-form::button type="submit" class="btn btn-primary float-end">Soumettre
                            </x-form::button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
