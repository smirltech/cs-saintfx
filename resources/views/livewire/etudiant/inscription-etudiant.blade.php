@php use App\Enum\EtudiantSexe;use App\Enum\EtudiantStep; @endphp
<div class="row">
    <div class="col-md-8 container p-5 d-flex flex-column align-items-center register-box">

        <div class="mb-3">
            <x-application-logo height="80"/>
        </div>
        <div>
            <x-validation-errors class="mb-4" :errors="$errors"/>
        </div>
        <div class="card">

            <div class="card-header bg-primary text-white">
                <h3 class="h-3">{{$etudiant?$etudiant->step->value."/5 - ":""}} {{$title}}</h3>
            </div>
            <div class="card-body">
                @if(!$etudiant)
                    @if(!$otp)
                        <form wire:submit.prevent="submitOtp" class="container">
                            <div class="mb-3">
                                <x-form-input
                                    wire:model="email"
                                    :is-valid="$errors->has('email')?false:null"
                                    :error="$errors->first('email')"
                                    placeholder="marien@upl-univ.ac" required>
                                </x-form-input>
                                <div class="form-text text-primary">
                                    Il est important de fournir une adresse e-mail valide pour recevoir les
                                    notifications
                                    sur
                                    votre inscription.
                                </div>
                            </div>
                            <x-form-button type="submit">
                                Poursuivre
                            </x-form-button>
                        </form>
                    @else
                        <form wire:submit.prevent="submitVerifyOtp" class="container">
                            <div class="mb-3">
                                <x-form-input
                                    minlenght="4"
                                    maxlength="4"
                                    type="number"
                                    label="Code de verification"
                                    placeholder="Entrez le code reçu par e-mail"
                                    wire:model="code" required>
                                </x-form-input>
                                <div class="form-text text-info">
                                    Le code de vérification a été envoyé à l'adresse {{ $email }},<br> si le code n'est
                                    pas
                                    reçu
                                    veillez rafrachir la page et réessayer une nouvelle adresse e-mail.
                                </div>
                            </div>
                            <x-form-button type="submit">
                                Valider
                            </x-form-button>
                        </form>
                    @endif
                @elseif($etudiant->step != EtudiantStep::complete)
                    <form wire:submit.prevent="submit{{$etudiant->step->value}}" class="container">
                        @if($etudiant->step == EtudiantStep::one)
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <x-form-input
                                            label="Nom"
                                            placeholder="Nom"
                                            wire:model="etudiant.nom" required>
                                        </x-form-input>
                                    </div>
                                    <div class="col-md-4">
                                        <x-form-input
                                            label="Post-nom"
                                            placeholder="Post-Nom"
                                            wire:model="etudiant.postnom" required>
                                        </x-form-input>
                                    </div>
                                    <div class="col-md-4">
                                        <x-form-input
                                            label="Prénom"
                                            placeholder="Prénom"
                                            wire:model="etudiant.prenom" required>
                                        </x-form-input>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-form-input
                                            label="Lieu de naissance"
                                            placeholder="Lubumbashi"
                                            wire:model="etudiant.lieu_naissance" required>
                                        </x-form-input>
                                    </div>
                                    <div class="col-md-6">
                                        <x-form-input
                                            label="Date de naissance"
                                            type="date"
                                            wire:model="etudiant.date_naissance" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <x-form-select
                                    label="Sexe"
                                    type="date"
                                    wire:model="etudiant.sexe" required>
                                    <option value="">Selectionnez le sexe</option>
                                    @foreach(EtudiantSexe::cases() as $sexe)
                                        <option value="{{$sexe->value}}">{{$sexe->label()}}</option>
                                    @endforeach
                                </x-form-select>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-form-input
                                            label="Adresse"
                                            placeholder="Adresse"
                                            wire:model="etudiant.adresse" required>
                                        </x-form-input>
                                    </div>
                                    <div class="col-md-6">
                                        <x-form-input
                                            label="Téléphone"
                                            placeholder="Téléphone"
                                            wire:model="etudiant.telephone" required>
                                        </x-form-input>
                                    </div>
                                </div>
                            </div>
                        @elseif($etudiant->step == EtudiantStep::two)
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-form-input
                                            label="Père"
                                            placeholder="Nom complet du pere"
                                            wire:model="etudiant.pere" required>
                                        </x-form-input>
                                    </div>
                                    <div class="col-md-6">
                                        <x-form-input
                                            label="Mère"
                                            placeholder="Nom complet de la mère"
                                            wire:model="etudiant.mere" required>
                                        </x-form-input>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <x-form-input
                                            label="Tuteur"
                                            placeholder="Nom complet du tuteur"
                                            wire:model="etudiant.tuteur" required>
                                        </x-form-input>
                                    </div>
                                    <div class="col-md-6">
                                        <x-form-input
                                            type="tel"
                                            label="Téléphone du tuteur"
                                            placeholder="Personne à contacter en cas d'urgence"
                                            wire:model="etudiant.contact_urgence" required>
                                        </x-form-input>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <x-form-input
                                            label="Adresse d'urgence"
                                            placeholder="Adresse en cas d'urgence"
                                            wire:model="etudiant.adresse_urgence">
                                        </x-form-input>
                                    </div>

                                </div>
                            </div>
                        @elseif($etudiant->step == EtudiantStep::three)
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <x-form-input
                                        type="file"
                                        class="form-control-file"
                                        accept="application/pdf"
                                        label="Certificat de bonne conduite, vie et mœurs"
                                        wire:model="certificat_bvm">
                                    </x-form-input>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <x-form-input
                                        type="file"
                                        class="form-control-file"
                                        accept="application/pdf"
                                        label="Certificat de naissance"
                                        wire:model="certificat_naissance">
                                    </x-form-input>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <x-form-input
                                        type="file"
                                        class="form-control-file"
                                        accept="application/pdf"
                                        label="Certificat de residence"
                                        wire:model="certificat_residence">
                                    </x-form-input>
                                </div>
                            </div>
                        @elseif($etudiant->step == EtudiantStep::four)
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <x-form-input
                                        label="Nom de l'école fréquentée"
                                        placeholder="CS. La Prosperité de Lulet 2"
                                        wire:model.lazy="diplome.ecole" required>
                                    </x-form-input>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <x-form-input
                                        label="Code"
                                        type="number"
                                        placeholder="536677756"
                                        wire:model.lazy="diplome.code_ecole" required>
                                    </x-form-input>
                                </div>

                                <div class="col-md-7 mb-3">
                                    <x-form-input
                                        label="Section suivie aux humanités"
                                        placeholder="Coupe et couture"
                                        wire:model.lazy="diplome.section" required>
                                    </x-form-input>
                                </div>

                                <div class="col-md-5 mb-3">
                                    <x-form-input
                                        label="Option"
                                        placeholder="Couture"
                                        type="text"
                                        wire:model.lazy="diplome.option">
                                    </x-form-input>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <x-form-input
                                        type="number"
                                        label="Année d'obtention du diplôme"
                                        placeholder="2017"
                                        wire:model.lazy="diplome.date_delivrance" required>
                                    </x-form-input>
                                </div>


                                <div class="col-md-9 mb-3">
                                    <x-form-input
                                        type="number"
                                        label="Numéro du diplôme (à laisser vide si vous n'en avez pas)"
                                        placeholder="201367565"
                                        wire:model.lazy="diplome.numero">
                                    </x-form-input>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <x-form-input
                                        type="number"
                                        label="Pourcentage"
                                        placeholder="62"
                                        wire:model.lazy="diplome.pourcentage">
                                    </x-form-input>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <x-form-input
                                        type="file"
                                        class="form-control-file"
                                        accept="application/pdf"
                                        label="Diplôme d'Etat ou Journal Officiel"
                                        wire:model="diplome_docu">
                                    </x-form-input>
                                </div>
                            </div>
                        @elseif($etudiant->step == EtudiantStep::five)
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <x-form-select
                                        label="Premier choix"
                                        wire:change="changeFaculte"
                                        wire:model="faculte_id" required>
                                        <option value="">Choisir une option</option>
                                        @foreach($facultes as $faculte)
                                            <option value="{{ $faculte->id }}">{{ $faculte->display_name }}</option>
                                        @endforeach
                                    </x-form-select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <x-form-select
                                        label="_"
                                        type="number"
                                        placeholder="536677756"
                                        wire:model="filiere_id" required>
                                        <option value="">Choisir une option</option>
                                        @foreach($filieres as $filiere)
                                            <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                        @endforeach
                                    </x-form-select>
                                </div>

                                <div class="col-md-8 mb-3">
                                    <x-form-select
                                        label="Deuxième choix"
                                        wire:change="changeFaculte2"
                                        wire:model="faculte2_id" required>
                                        <option value="">Choisir une option</option>
                                        @foreach($facultes as $faculte)
                                            <option value="{{ $faculte->id }}">{{ $faculte->display_name }}</option>
                                        @endforeach
                                    </x-form-select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <x-form-select
                                        label="_"
                                        type="number"
                                        placeholder="536677756"
                                        wire:model="filiere2_id" required>
                                        <option value="">Choisir une option</option>
                                        @foreach($filieres2 as $filiere)
                                            <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                        @endforeach
                                    </x-form-select>
                                </div>

                                <div hidden class="col-md-12 mb-3">
                                    <x-form-input
                                        type="file"
                                        class="form-control-file"
                                        accept="application/pdf"
                                        label="Preuve de paiement (Facultatif)"
                                        wire:model="bordereau">
                                    </x-form-input>
                                </div>
                            </div>
                        @endif
                        <x-form-button type="submit">
                            Poursuivre
                        </x-form-button>
                    </form>
                @else
                    <div class="alert alert-success">
                        <h4 class="alert-heading">Félicitation!</h4>
                        <p>Votre inscription a été enregistrée avec succès. Vous pouvez désormais vous attendre à etre
                            notifié par mail de la suite à donner.</p>
                        <hr>
                        <p class="mb-0">Merci.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
