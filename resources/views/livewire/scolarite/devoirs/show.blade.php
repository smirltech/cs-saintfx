@php use App\Enums\ClasseGrade;use Carbon\Carbon; @endphp
@section('title')
    {{$devoir->titre}}
@endsection
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
                                <x-list-files :media="$devoir->media"/>
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
                                    <x-form-input
                                        required placeholder="Saisir le numéro de l'élève"
                                        wire:model="matricule" type="number"
                                        label="Matricule de l'élève"
                                        minlenght="10" maxlength="10"
                                        :isValid="$errors->has('matricule') ? false : null"
                                        error="{{$errors->first('matricule')}}"/>
                                    <div class="valid-feedback">
                                        {{$eleve?->nom_complet}}
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <x-form-textarea
                                        placeholder="Saisir le contenu de la réponse"
                                        wire:model.defer="devoir_reponse.contenu"
                                        label="Contenu de la réponse"
                                        rows="10"
                                        :isValid="$errors->has('devoir_reponse.contenu') ? false : null"
                                        error="{{$errors->first('devoir_reponse.contenu')}}"/>

                                </div>

                                <div class="form-group col-md-12">
                                    <x-form-file-pdf wire:model="document"
                                                     label="Pièce jointe"
                                                     required
                                                     target="document"
                                                     :isValid="$errors->has('document') ? false : null"
                                                     error="{{$errors->first('document')}}"/>
                                    <x-list-files :media="$devoir_reponse->media??[]" delete/>
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

