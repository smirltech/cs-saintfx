@php use App\Helpers\Helpers;use Carbon\Carbon; @endphp
<div wire:ignore.self class="modal fade" tabindex="-1" id="recu-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Imprimer Reçu</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body m-0 p-0">
                    <div id="factPrint" class="text-center" style="text-align:center">
                        <div style="text-align:center" class="text-center">
                            <img width="80px" src="{{url('/images/logo.png')}}" alt="cenk logo">
                        </div>
                        <h2 hidden="hidden" class="text-center"><strong>COLLEGE CENK</strong></h2>
                        <div class="text-center">{{$fee?->nom}}</div>
                        <div hidden class=" text-center"><span>phone:000</span>
                            <span hidden class="">email:email</span>
                        </div>

                        <div style="text-align:center" class="text-center">Reçu
                            No.{{$perception?->reference}}</div>
                        <div style="text-align:center" class="text-center">
                            Date: {{Carbon::now()->format("d-m-Y à H:i:s")}}
                        </div>
                        <br>
                        <div style="text-align:center" class="text-center">Élève :
                            <strong>{{$inscription?->fullName}}</strong></div>
                        <br>
                        <div style="text-align:center; width: 100%">
                            <span style="text-align:left; margin-right: 10px"
                                  class="">{{$inscription?->classe->grade}} </span>
                            <span style="text-align:center; margin-right: 10px"
                                  class=""> {{$inscription?->classe->filierable->nom}} </span>
                            <span style="text-align:right" class=""> {{$annee->nom}}</span>

                        </div>
                        <br>
                        {{--<div class="d-flex  justify-content-evenly">
                            <span class="">{{$fee->type->label()}}</span>
                            <span>{{$fee->frequence->label()}}</span>
                        </div>
                        <br>--}}
                        <div class="table-responsive">
                            <table style="width:100%" class="table">
                                <thead>
                                <tr>
                                    <th style="text-align:left">FRAIS</th>
                                    <th style="text-align:right">MONTANT</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-dark">
                                    <td style="text-align:left">{{$perception?->frais?->nom}} {{$perception?->custom_property}}</td>
                                    <td style="text-align:right">{{Helpers::currencyFormat($perception?->montant)}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        {{--<div class="text-right">Total :
                            <strong>{{Helpers::currencyFormat($montant)}}</strong></div>--}}
                        <div style="text-align:right" class="text-right">Cash :
                            <strong>{{Helpers::currencyFormat($perception?->paid)}} Fc</strong></div>
                        <div style="text-align:right" class="text-right">Solde :
                            <strong>{{Helpers::currencyFormat($perception?->montant - (int)($perception?->paid))}}
                                Fc</strong>
                        </div>
                        @if($perception?->paid_by != null)
                            <div style="text-align:right" class="text-right">Payé par :
                                <strong>{{$perception?->paid_by}}</strong></div>
                        @endif
                        <br>
                        <div style="text-align:center" class="text-center">
                            <strong class="w3-center justify-content-center w3-small">School Motto Here !</strong>
                        </div>

                        <div hidden="hidden" class="w3-small text-center">CENK - FINANCE</div>

                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-center">

                <button wire:click="printIt" type="button" class="btn btn-success">Imprimer
                </button>
            </div>
        </div>

    </div>
</div>


