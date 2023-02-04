@php use Carbon\Carbon; @endphp
<div>

        <div class="">
            <div style="text-align: center;" class=" justify-content-center">
                CENK FINANCE - {{$anneeNom}}
            </div>
            <br>
        </div>
        <div class="">
            <div class="card">
                <div style="display: flex; justify-content: space-between" class="card-header">
                    <div class="card-title">Rapport financier de la période</div>
                    <div class="card-tools d-flex">
                            <div class="mr-2">Debut : {{Carbon::parse($ddebut)->format('d-m-Y')}}</div>
                            <div class="ml-2"> Fin : {{Carbon::parse($dfin)->format('d-m-Y')}}</div>
                    </div>
                </div>
                <div class="card-body m-b-5">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Entrées</h4>
                            <hr>
                            <ul class="list-group">
                                @if($revenuAuxiliaire != 0)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Revenu Auxiliaire
                                        <span style="float: right"
                                              class="">{{number_format($revenuAuxiliaire)}} Fc</span>
                                    </li>
                                @endif
                                @if($perception != 0)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Perceptions
                                        <span style="float: right"
                                              class="">{{number_format($perception)}} Fc</span>
                                    </li>
                                    <ul class="list-group">
                                        @foreach($frais as $k=>$fee)
                                            @if($fee > 0)
                                                <li class="pl-5 pr-5 list-group-item d-flex justify-content-between align-items-center font-italic">
                                                    {{$k}}
                                                    <span style="float: right; padding-right: 25px"
                                                          class=""><i>{{number_format($fee)}} Fc</i></span>
                                                </li>
                                            @endif

                                        @endforeach
                                    </ul>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4>Sorties</h4>
                            <hr>
                            <ul class="list-group">
                                @if($depenses != 0)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Dépenses
                                        <span style="float: right"
                                              class="">{{number_format($depenses)}} Fc</span>
                                    </li>
                                    <ul class="list-group">
                                        @foreach($depensesTypes as $k=>$depenseType)
                                            @if($depenseType > 0)
                                                <li class="pl-5 pr-5 list-group-item d-flex justify-content-between align-items-center font-italic">
                                                    {{$k}}
                                                    <span style="float: right;padding-right: 25px"
                                                          class=""><i>{{number_format($depenseType)}} Fc</i></span>
                                                </li>
                                            @endif

                                        @endforeach
                                    </ul>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

