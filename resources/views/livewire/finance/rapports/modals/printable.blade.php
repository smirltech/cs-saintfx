@php use App\Enums\FraisType;use App\Models\Annee;use App\Models\Perception;use Illuminate\Support\Carbon; @endphp
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
                <div class="card-title">Rapport financier de la période du {{Carbon::parse($date_from)->format('d/m/Y')}} au  {{Carbon::parse($date_to)->format('d/m/Y')}}</div>
                <div class="card-tools d-flex">
                    <div class="ml-2"> Compte : {{auth()->user()->name}}</div>
                    <div class="ml-2"> Date : {{Carbon::now()->format('d-m-Y H:i')}}</div>
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
                                </li>
                                <table class="table table-bordered table-striped">
                                    <thead class="text-center">
                                    <tr class="titres">
                                        <th rowspan="2">Type</th>
                                        <th colspan="2">Fc</th>
                                        <th colspan="2">$</th>
                                    </tr>
                                    <tr class="titres">
                                        <th>Nbre</th>
                                        <th>Montant</th>
                                        <th>Nbre</th>
                                        <th>Montant</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php


                                        $perceptionCDFCountTotal = 0;
                                        $perceptionUSDCountTotal = 0;

                                        $perceptionCDFTotal = 0;
                                        $perceptionUSDTotal = 0;
                                    @endphp
                                    @foreach(FraisType::cases() as $k=>$type)
                                        @php
                                            $perceptionQuery = Perception::whereHas('frais', function ($q) use ($type) {
                                                $q->where('type', $type);
                                            })
                                            ->whereDate('created_at', '>=', $date_from)
                                            ->whereDate('created_at', '<=', $date_to);

                                            $perceptionCDFCount = $perceptionQuery->clone()->cdf()->count();
                                            $perceptionUSDCount = $perceptionQuery->clone()->usd()->count();

                                            $perceptionCDF = $perceptionQuery->clone()->cdf()->sum('montant');
                                            $perceptionUSD = $perceptionQuery->clone()->usd()->sum('montant');

                                            $perceptionCDFCountTotal += $perceptionCDFCount;
                                            $perceptionUSDCountTotal += $perceptionUSDCount;
                                            $perceptionCDFTotal += $perceptionCDF;
                                            $perceptionUSDTotal += $perceptionUSD;


                                        @endphp
                                        <tr class="titres">
                                            <td style="text-align: left">{{$type->label()}}</td>
                                            <td class="text-center">{{$perceptionCDFCount}}</td>
                                            <td class="text-center">{{number_format($perceptionCDF)}}</td>
                                            <td class="text-center">{{$perceptionUSDCount}}</td>
                                            <td class="text-center">{{number_format($perceptionUSD)}}</td>
                                        </tr>

                                    @endforeach
                                    <tr class="titres">
                                        <th>Total</th>
                                        <th class="text-center">{{number_format($perceptionCDFCountTotal)}}</th>
                                        <th class="text-center">{{number_format($perceptionCDFTotal)}}Fc</th>
                                        <th class="text-center">{{number_format($perceptionUSDCountTotal)}}</th>
                                        <th class="text-center">{{number_format($perceptionUSDTotal)}}$</th>
                                    </tr>
                                    </tbody>
                                </table>
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
    <style>
        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: #454342;
        }


        .titres > th, .titres > td, .cotes > td {
            border: 1px solid gray;
            padding: 3px;
        }

        .titres > td, .titres > th {
            text-align: center;
            font-weight: 500;
            padding: 5px;

        }

        .titres > th {
            font-weight: bold;

        }


    </style>

</div>
