@php use Carbon\Carbon; @endphp
@section('title')
    {{Str::upper('cenk')}} - élève - {{$eleve->fullName}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-user mr-1"></span>Élève</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.eleves') }}">Élèves</a></li>
                <li class="breadcrumb-item active">Élève</li>
            </ol>
        </div>
    </div>

@stop
<div>
    @include('livewire.scolarite.eleves.modals.crud')

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="{{$eleve->profile_url}}" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{$eleve->fullName}}</h3>
                            <p class="text-muted text-center">CODE : {{$eleve->code}}</p>
                            <p class="text-muted text-center">CLASSE
                                : {{$inscription?->classe?->shortCode??'Non encore inscrit !'}}</p>
                            <p class="text-muted text-center">ANNEE SCOLAIRE : {{$annee_courante?->nom??''}}</p>
                        </div>

                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Information Personnelle</h3>
                            <div class="card-tools">
                                <span role="button" class="mr-1"
                                      data-toggle="modal"
                                      data-target="#edit-eleve-modal"><span
                                        class="fas fa-pen"></span></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <strong><i class="fas fa-id-card-alt mr-1"></i> No. Permanent</strong>
                            <p class="text-muted">
                                {{$eleve->numero_permanent??''}}
                            </p>
                            <hr>
                            <strong><i class="fas fa-user mr-1"></i> Nom</strong>
                            <p class="text-muted">
                                {{$eleve->nom}}
                            </p>
                            <hr>
                            <strong><i class="fas fa-user mr-1"></i> Postnom</strong>
                            <p class="text-muted">
                                {{$eleve->postnom}}
                            </p>
                            <hr>
                            <strong><i class="fas fa-user mr-1"></i> Prenom</strong>
                            <p class="text-muted">
                                {{$eleve->prenom}}
                            </p>
                            <hr>
                            <strong><i class="fas fa-venus-mars mr-1"></i> Sexe</strong>
                            <p class="text-muted">
                                {{$eleve->sexe->value??''}}
                            </p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Lieu de naissance</strong>
                            <p class="text-muted">
                                {{$eleve->lieu_naissance}}
                            </p>
                            <hr>
                            <strong><i class="fas fa-calendar-alt mr-1"></i> Date de naissance</strong>
                            <p class="text-muted">
                                {{$eleve->date_naissance?->format('d/m/Y')??''}}
                                <strong
                                    class="float-right badge bg-gradient-info">{{Carbon::now()->diffInYears($eleve->date_naissance)}}
                                    ans</strong>
                            </p>
                            <hr>
                            <strong><i class="fas fa-phone-alt mr-1"></i> Téléphone</strong>
                            <p class="text-muted">{{$eleve->telephone}}</p>
                            <hr>
                            <strong><i class="fas fa-envelope mr-1"></i> E-mail</strong>
                            <p class="text-muted">{{$eleve->email}}</p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Adresse</strong>
                            <p class="text-muted">{{$eleve->adresse}}</p>

                        </div>

                    </div>
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">État Financier</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Inscription : </b> <span
                                        class="float-right">{{\App\Helpers\Helpers::currencyFormat($inscription?->montant, symbol: 'Fc')}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Facture : </b> <span
                                        class="float-right">{{\App\Helpers\Helpers::currencyFormat(39000, symbol: 'Fc')}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Reçu : </b> <span
                                        class="float-right">{{\App\Helpers\Helpers::currencyFormat(9000, symbol: 'Fc')}}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Balance : </b> <span class="float-right"><i
                                            class="badge bg-warning">{{\App\Helpers\Helpers::currencyFormat(30000, symbol: 'Fc')}}</i></span>
                                </li>
                            </ul>
                            <a hidden href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                        </div>

                    </div>
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"> Responsable / Tuteur</h3>
                            @if(!$eleve->responsable_eleve)
                                <div class="card-tools">
                                <span title="Attacher" role="button" class="mr-2"
                                      data-toggle="modal"
                                      data-target="#attach-responsable-modal"><span
                                        class="fas fa-plus"></span></span>
                                </div>
                            @endif
                        </div>
                        @if($eleve->responsable_eleve)
                            <div class="card-body">
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Responsable</b> <span class="float-right"><a
                                                href="/scolarite/responsables/{{$eleve->responsable_eleve?->responsable?->id}}">{{$eleve->responsable_eleve?->responsable?->nom??''}}</a></span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Relation</b> <span class="float-right">{{$eleve->responsable_eleve?->relation?->label()??''}}<span
                                                title="Modifier" role="button" class=" fa fa-link ml-1"
                                                data-toggle="modal"
                                                data-target="#edit-relation-modal"></span></span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Sexe</b> <span
                                            class="float-right">{{$eleve->responsable_eleve?->responsable?->sexe??''}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Téléphone</b> <span
                                            class="float-right">{{$eleve->responsable_eleve?->responsable?->telephone??''}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>E-mail</b> <span
                                            class="float-right">{{$eleve->responsable_eleve?->responsable?->email??''}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Adresse</b> <span
                                            class="float-right">{{$eleve->responsable_eleve?->responsable?->adresse??''}}</span>
                                    </li>
                                </ul>

                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="admission">
                                    <div class="">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Cursus Scolaire</h4>
                                                <div class="card-tools">
                                                    <button role="button" class="btn btn-warning"
                                                            data-toggle="modal"
                                                            data-target="#add-inscription-modal"><span
                                                            class="fas fa-plus"></span></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <div class="timeline">
                                                            @foreach($eleve->inscriptions as $inscription)
                                                                @php
                                                                  $resultats =  $eleve->resultatsOfYear(annee_id:$inscription->annee_id);
                                                                  $lastResultat = $resultats->last();
                                                                  $mention = "Pas d'info";
                                                                  if($lastResultat != null)$mention = $lastResultat?->pourcentage >= 50?'Réussite':'Échec';
                                                                @endphp
                                                                <div class="time-label">
                                                                    <span
                                                                        wire:click="getSelectedInscription({{$inscription}})"
                                                                        role="button" class="bg-green"
                                                                        data-toggle="modal"
                                                                        data-target="#edit-inscription-modal">{{$inscription->classe->shortCode}}</span>
                                                                </div>

                                                                <div>
                                                                    <i class="fas fa-clock bg-maroon"></i>
                                                                    <div class="timeline-item">
                                                                            <span class="time"><i
                                                                                    class="fas fa-clock mr-1"></i>{{$inscription->created_at->format('d-m-Y')}}</span>
                                                                        <h3 class="timeline-header"><a>{{$mention}}</a>
                                                                            avec {{$lastResultat?->pourcentage}}%</h3>
                                                                        <div style="width: 100%" class="timeline-body ">
                                                                            <div class="table-responsive-sm">
                                                                           <table class="table">
                                                                               <thead>
                                                                               <tr>
                                                                                   <th scope="col">RÉSULTAT</th>
                                                                                   <th scope="col">POURCENTAGE</th>
                                                                                   <th scope="col">PLACE</th>
                                                                                   <th scope="col"></th>
                                                                               </tr>
                                                                               </thead>
                                                                               <tbody>
                                                                               @foreach($resultats as $resultat)
                                                                                   <tr>
                                                                                       <th scope="row">{{$resultat->custom_property}}</th>
                                                                                       <td>{{$resultat->pourcentage}}%</td>
                                                                                       <td>{{$resultat->place}}</td>
                                                                                       <td>
                                                                                           <div class="d-flex float-right">
                                                                                               <button type="button"
                                                                                                       title="Téléverser bulletin" class="btn btn-outline-info btn-xs  ml-2">
                                                                                                   <span class="fa fa-upload"></span>
                                                                                               </button>
                                                                                               <button type="button"
                                                                                                       title="Télécharger bulletin" class="btn btn-outline-info btn-xs  ml-2">
                                                                                                   <span class="fa fa-download"></span>
                                                                                               </button>
                                                                                           </div>
                                                                                       </td>
                                                                                   </tr>
                                                                               @endforeach

                                                                               </tbody>
                                                                           </table>
                                                                                <div class="d-flex">
                                                                                    <button type="button"
                                                                                            title="Ajouter Résultat" class="btn btn-outline-primary btn-xs  ml-2">
                                                                                        <span class="fa fa-plus"></span>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        {{--<div
                                                                            class="timeline-footer d-flex justify-content-between">
                                                                                <span title="Changer"
                                                                                      wire:click="getSelectedInscription({{$inscription}})"
                                                                                      role="button" data-toggle="modal"
                                                                                      data-target="#edit-inscription-categorie-modal"
                                                                                      class="border border-success rounded p-1">{{$inscription->categorie->label()}}</span>
                                                                            <span title="Changer"
                                                                                  wire:click="getSelectedInscription({{$inscription}})"
                                                                                  role="button" data-toggle="modal"
                                                                                  data-target="#edit-inscription-status-modal"
                                                                                  class="border border-warning rounded p-1 ">{{$inscription->status->label()}}</span>
                                                                        </div>--}}
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                            <div>
                                                                <i class="fas fa-clock bg-gray"></i>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

