@extends('adminlte::page')
@section('content_header')

@endsection

@section('content')
    <div class="p-0 container-fluid mt-3">
        <div class="row">
            <div class="col-md-7">
                <livewire:demande-validation :demande="$demande"/>
            </div>
            <div class="col-md-5">
                <div class="card mb-7">
                    <div class="card-header">
                        <div class="m-0 box_header">
                            <div class="main-title">
                                <h3 class="m-0">{{__("Relevées disponibles")}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 card-body">
                        @if($etudiant)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">{{__("Etudiant")}}</label>
                                        <input type="text" class="form-control"
                                               value="{{$etudiant->matricule}} | {{$etudiant->nom}}"
                                               readonly>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">{{__("Mentions")}}</label>

                                        <ul>

                                            @forelse($mentions as $mention)
                                                <li class="border-bottom mb-3">
                                                    {{-- {{json_encode($mention)}}<br>--}}
                                                    <strong>{{$mention->promotion}} : {{$mention->pourcentage}}
                                                        %</strong> <br>
                                                    Moyenne : {{$mention->moyenne_ponderee}} | Credits
                                                    Validés : {{$mention->credits_valide}} | Echecs
                                                    : {{$mention->nbre_echecs}} <br>
                                                    Decision : {{$mention->decision}} | Session
                                                    : {{$mention->msession}} | Anneé : {{$mention->annee}}

                                                </li>
                                            @empty
                                                <li>{{__("Aucun relevé disponible")}}</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <p>{!!$errorMessage!!}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
