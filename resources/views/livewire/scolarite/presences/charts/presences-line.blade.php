@php
    use App\Enums\PresenceStatus;use App\Models\Presence;use Asantibanez\LivewireCharts\Models\ColumnChartModel;use Asantibanez\LivewireCharts\Models\LineChartModel;use Carbon\Carbon;use Carbon\CarbonInterval;

  $dates = new DatePeriod(
        Carbon::now()->subDays(30),
        CarbonInterval::day(),
        Carbon::tomorrow(),
     );
    $lineChartModel =
            (new ColumnChartModel())
            ->setTitle("Du ".$dates->start->format('d/m/Y')." au ".$dates->end->format('d/m/Y'))->multiColumn();


    $totalPresences = 0;
    foreach ($dates as $date) {
        $filles = Presence::whereDate('date', $date->format('Y-m-d'))->sum('filles');
    $garcons = Presence::whereDate('date', $date->format('Y-m-d'))->sum('garcons');


     $lineChartModel->addSeriesColumn('Garçons', $date->format('d'), $garcons);
    $lineChartModel->addSeriesColumn('Filles', $date->format('d'), $filles);
     $lineChartModel->addSeriesColumn('Absents', $date->format('d'), Presence::whereDate('date', $date->format('Y-m-d'))->sum('absents'));
      }
@endphp
<div class="card">

    <div class="card-header">
        Présences - {{$filles + $garcons}}
    </div>

    <div class="card-body" style="height: 20rem;">
        <livewire:livewire-column-chart
            key="{{ $lineChartModel->reactiveKey() }}"
            :column-chart-model="$lineChartModel"/>
    </div>
</div>
