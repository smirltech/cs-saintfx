@php use App\Enum\DemandeStatus;use App\Enum\Permission\DemandePermission;use App\Enum\RejectRaison; @endphp
<div class="card mb-7">
    <div class="card-header">
        <div class="m-0 box_header">
            <div class="main-title">
                <h3 class="m-0">Demane No. {{$demande->id}} | <span
                        class="badge bg-{{$demande->status_variant}}"> {{$demande->status->label()}} </span>
                </h3>
            </div>

        </div>
    </div>
    <div class="mb-3 card-body">
        <div class="row container">
            @if(!$validate)
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__("Matricule")}}</label>
                        <input type="text" class="form-control" value="{{$demande->matricule}}"
                               readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__("Nom")}}</label>
                        <input type="text" class="form-control" value="{{$demande->nom}}" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__("E-mail")}}</label>
                        <input type="text" class="form-control" value="{{$demande->email}}"
                               readonly>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__("Grades")}}</label>
                        <ul>
                            @foreach($demande->grades as $grade)
                                <li>
                                    {{$grade}}
                                    @if($demande->status->isAccepted())
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <a href="{{$demande->generateReleveLink($grade)}}"
                                                   target="_blank"
                                                   class="btn btn-outline-primary mx-1"
                                                   title="Telecharger le relevé"> <i
                                                        class="fa fa-lg fa-fw fa-qrcode"></i>
                                                </a>
                                                <a href="{{$demande->generateRelevePrintLink($grade)}}"
                                                   class="btn btn-outline-primary mx-1"
                                                   title="Imprimer le relevé"> <i
                                                        class="zmdi zmdi-print"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__("Bordereaux")}}</label>
                        @if($demande->bordereaux)
                            <ul>
                                @foreach($demande->bordereaux as $media)
                                    <li>
                                        <a href="{{ $media->location_demande }}"><b>{{explode(':',$media->custom_property)[1]}}</b>
                                            | {{ $media->filename }}
                                            ({{ Helpers::formatBytes($media->size) }}
                                            ), {{ $media->created_at }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>{{__("Aucun bordereau")}}</p>
                        @endif
                    </div>
                </div>

                <hr>
            @endif
            @can(DemandePermission::update())
                @if(!$demande->isAccepted())
                    <div class="col-md-12">
                        <div class="form-group">
                            @if(!$validate)
                                <button wire:click="$set('validate', true)" class="btn btn-primary"
                                        href="{{route('demandes.validate',$demande)}}">{{__("Valider")}}</button>
                            @endif
                            @if($validate)
                                <form wire:submit.prevent="submit">
                                    <div class="mb-3">
                                        <label>Action</label>
                                        <select wire:model="status" class="form-control  form-select">
                                            <option
                                                value="{{DemandeStatus::accepted->value}}">{{DemandeStatus::accepted->action()}}</option>
                                            <option
                                                value="{{DemandeStatus::rejected->value}}">{{DemandeStatus::rejected->action()}}</option>
                                        </select>
                                    </div>
                                    @if($status==DemandeStatus::rejected->value)
                                        <div class="mb-3">
                                            <label>Motif</label>
                                            <select wire:change="setRejectComment" wire:model="reject_reason"
                                                    class="form-control  form-select">
                                                @foreach(RejectRaison::cases() as $reason)
                                                    <option value="{{$reason->value}}">{{$reason->label()}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Commentaire</label>
                                            <textarea wire:model="reject_comment" class="form-control"
                                                      rows="5">{{ $reject_reason}}</textarea>
                                        </div>
                                    @endif
                                    <button type="submit" class="btn btn-primary float-end">{{__("ENVOYER")}}</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            @endcan
        </div>
    </div>

</div>
