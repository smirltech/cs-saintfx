@php
    use App\Enums\PresenceStatus;use App\Models\Presence;use Asantibanez\LivewireCharts\Models\ColumnChartModel;use Asantibanez\LivewireCharts\Models\LineChartModel;use Carbon\Carbon;use Carbon\CarbonInterval;

  $dates = new DatePeriod(
        Carbon::now()->startOfWeek(),
        CarbonInterval::day(),
        Carbon::tomorrow(),
     );
    $columnChartModel =
            (new ColumnChartModel())
            ->setTitle("Du ".$dates->start->format('d/m/Y')." au ".$dates->end->format('d/m/Y'))->multiColumn();


    $totalPresences = 0;
    foreach ($dates as $date) {

        $mat = Presence::whereDate('date', $date->format('Y-m-d'))
            ->whereHas('classe', function ($query) {
                $query->where('section_id', 1);
            })
        ->sum('total');

    $primaire = Presence::whereDate('date', $date->format('Y-m-d'))
      ->whereHas('classe', function ($query) {
                $query->where('section_id', 2);
            })
            ->sum('total');

    $sec = Presence::whereDate('date', $date->format('Y-m-d'))
      ->whereHas('classe', function ($query) {
                $query->where('section_id', 3);
            })
    ->sum('total');


     $columnChartModel->addSeriesColumn('MAT', $date->format('d'), $primaire);
    $columnChartModel->addSeriesColumn('P', $date->format('d'), $mat);
     $columnChartModel->addSeriesColumn('S', $date->format('d'), $sec);
     $columnChartModel->withDataLabels();
     $columnChartModel->withLegend();
    }
@endphp
<div class="card">

    <div class="card-header">
        Présences - {{Presence::lastTotal()}} élèves
    </div>

    <div class="card-body" style="height: 20rem;">
        <livewire:livewire-column-chart
            key="{{ $columnChartModel->reactiveKey() }}"
            :column-chart-model="$columnChartModel"/>
    </div>
</div>
