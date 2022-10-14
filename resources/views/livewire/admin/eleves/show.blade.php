@php use Carbon\Carbon; @endphp
<div class="content mt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img hidden class="profile-user-img img-fluid img-circle"
                                 src="../../dist/img/user4-128x128.jpg" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{$etudiant->fullName}}</h3>
                        <p class="text-muted text-center">{{$admission->promotion->code}}</p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Nom</b> <span class="float-right">{{$etudiant->nom}}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Postnom</b> <span class="float-right">{{$etudiant->postnom}}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Prenom</b> <span class="float-right">{{$etudiant->prenom}}</span>
                            </li>
                            <li class="list-group-item">
                                <b>{{$etudiant->matricule?'Matricule':'Code Temporaire'}}</b> <span
                                    class="float-right">{{$etudiant->matricule??$admission->code}}</span>
                            </li>
                        </ul>
                        <a hidden href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                    </div>

                </div>


                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">À propos</h3>
                    </div>

                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Lieu et date de naissance</strong>
                        <p class="text-muted">
                            {{$etudiant->lieu_naissance}}, le {{$etudiant->date_naissance?->format('d/m/Y')??''}}
                            <strong
                                class="float-right badge bg-gradient-info">{{Carbon::now()->diffInYears($etudiant->date_naissance)}}
                                ans</strong>
                        </p>
                        <hr>
                        <strong><i class="fas fa-phone-alt mr-1"></i> Téléphone</strong>
                        <p class="text-muted">{{$etudiant->telephone}}</p>
                        <hr>
                        <strong><i class="fas fa-envelope mr-1"></i> E-mail</strong>
                        <p class="text-muted">{{$etudiant->email}}</p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Adresse</strong>
                        <p class="text-muted">{{$etudiant->adresse}}</p>
                        <hr>
                        <strong><i class="fas fa-venus-mars mr-1"></i> Sexe</strong>
                        <p class="text-muted">
                            {{$etudiant->sexe->value??''}}
                        </p>
                        <hr>
                        <strong><i class="fas fa-people-arrows mr-1"></i> Etat civil</strong>
                        <p class="text-muted">
                            {{$etudiant->etat_civil->value??''}}
                        </p>

                    </div>

                </div>

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> Responsables / Tuteurs</h3>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Père</b> <span class="float-right">{{$etudiant->pere}}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Mère</b> <span class="float-right">{{$etudiant->mere}}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Tuteur</b> <span class="float-right">{{$etudiant->tuteur}}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Origine</b> <span class="float-right">{{$etudiant->origine}}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Adresse Urgence</b> <span class="float-right">{{$etudiant->adresse_urgence}}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Contact Urgence</b> <span class="float-right">{{$etudiant->contact_urgence}}</span>
                            </li>
                        </ul>

                    </div>

                </div>

            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#admission"
                                                    data-toggle="tab">Admission</a>
                            </li>
                            <li class="nav-item"><a class="nav-link " href="/admin/admissions/{{$admission->id}}/edit">Modifier</a>
                            </li>

                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="admission">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Diplôme</h4>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item">
                                                        <b>Numéro</b> <span
                                                            class="float-right">{{$etudiant->diplome->numero}}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Pourcentage Obtenu</b> <span class="float-right">{{$etudiant->diplome->pourcentage}}%</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Section</b> <span
                                                            class="float-right">{{$etudiant->diplome->section}}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Option</b> <span
                                                            class="float-right">{{$etudiant->diplome->option}}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Date de délivrance</b> <span
                                                            class="float-right">{{$etudiant->diplome->date_delivrance?->format('d/m/Y')??''}}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>École fréquentée</b> <span
                                                            class="float-right">{{$etudiant->diplome->ecole}}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Code École</b> <span
                                                            class="float-right">{{$etudiant->diplome->code_ecole}}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Province</b> <span
                                                            class="float-right">{{$etudiant->diplome->province_ecole}}</span>
                                                    </li>
                                                </ul>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Choix de filière</h4>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item">
                                                        <b>1e Choix</b> <span
                                                            class="float-right">{{$admission->promotion->code??""}}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>2e Choix</b> <span
                                                            class="float-right">{{$admission->promotion2->code??""}}</span>
                                                    </li>
                                                </ul>
                                            </div>


                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Documents ({{count($etudiant->media)}})</h4>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group list-group-unbordered">
                                                    @foreach($etudiant->media as $medium)
                                                        <li class="list-group-item">
                                                            <b>{{$medium->custom_property->label()}}</b> :
                                                            <i>{{$medium->filename}}</i> <a target="_blank"
                                                                                            href="{{$medium->path}}"
                                                                                            class="float-right btn btn-outline-success fas fa-download"></a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <li class="list-group-item">
                                    <b>Status d'admission</b> <span
                                        class="ml-3 btn btn-outline-success">{{$admission->status->label()}}</span>
                                </li>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

