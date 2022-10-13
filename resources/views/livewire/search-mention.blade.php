<div class="p-0 container-fluid mt-3">
    <div class="row">
        <div class="col-md-5">
            <div class="card mb-7">
                <div class="mb-3 card-body">
                    <form method="get" class="row container" action="{{route('admin.search')}}">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">{{__("Matricule")}}</label>
                                <input required name="matricule" max="10000000000" min="1000000000"
                                       type="number"
                                       class="form-control"
                                       value="{{$matricule}}">
                            </div>
                        </div>
                        @csrf
                        <hr>
                        <button class="btn btn-primary"><i class="fa fa-search"> </i> {{__("RECHERCHER")}}</button>
                    </form>
                </div>

            </div>
        </div>
        <div class="col-md-7">
            <div class="card mb-7">
                <div class="mb-3 card-body">
                    @if($etudiant)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control"
                                           value="{{$etudiant['matricule']}} | {{$etudiant['nom']}}"
                                           readonly>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Demandes</label>
                                    <ul>

                                        @forelse($demandes as $demande)
                                            <li class="border-bottom">
                                                {{-- {{json_encode($mention)}}<br>--}}
                                                <div class="row">
                                                    <div class="col-8">
                                                        <span class="badge bg-{{$demande->status_variant}}">
                                                            {{$demande->status_display}}
                                                        </span>
                                                        <strong>{{$demande->promotion}}
                                                            : {{$demande->updated_at}}</strong>
                                                        <br>
                                                        Promotions : {{$demande->promotions}}
                                                    </div>
                                                    <div class="col-4">
                                                        <a href="{{route('demandes.show',$demande)}}"
                                                           class="btn btn-primary btn-sm float-end">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li>{{__("Aucune demande disponible")}}</li>
                                        @endforelse
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label for="">{{__("Mentions")}}</label>
                                    <ul>

                                        @forelse($etudiant['mentions'] as $demande)
                                            @php
                                                $demande = (object)$demande;
                                            @endphp
                                            <li class="border-bottom mb-3">
                                                {{-- {{json_encode($mention)}}<br>--}}
                                                <div>
                                                    <strong>{{$demande->promotion}} : {{$demande->pourcentage}}
                                                        %</strong> <br>
                                                    Moyenne : {{$demande->moyenne_ponderee}} | Echecs
                                                    : {{$demande->nbre_echecs}} |
                                                    Decision : {{$demande->decision}} | Anneé : {{$demande->annee}}
                                                </div>
                                            </li>
                                        @empty
                                            <li>{{__("Aucun etudiant disponible")}}</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            {{__("Aucun etudiant trouvé correspondant à ce matricule")}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
