@php
    use App\Enums\PresenceStatus;use App\Models\Presence;use Asantibanez\LivewireCharts\Models\LineChartModel;use Carbon\Carbon;use Carbon\CarbonInterval;

  $dates = new DatePeriod(
        Carbon::now()->subDays(30),
        CarbonInterval::day(),
        Carbon::tomorrow(),
     );
    $lineChartModel =
            (new LineChartModel())
            ->setTitle("Du ".$dates->start->format('d/m/Y')." au ".$dates->end->format('d/m/Y'))
            ->multiLine();


    foreach ($dates as $date) {
        $filles = Presence::whereDate('date', $date->format('Y-m-d'))->sum('filles');
    $garcons = Presence::whereDate('date', $date->format('Y-m-d'))->sum('garcons');

    $lineChartModel->addSeriesPoint('Filles', $date->format('d'), $filles);
    $lineChartModel->addSeriesPoint('Garçons', $date->format('d'), $garcons);
    $lineChartModel->addSeriesPoint('Absents', $date->format('d'), Presence::whereDate('date', $date->format('Y-m-d'))->sum('absents'));
      }
@endphp
<div class="card">

    <div class="card-header">
        Présences
    </div>

    <div class="card-body" style="height: 20rem;">
        <livewire:livewire-line-chart
                key="{{ $lineChartModel->reactiveKey() }}"
            :line-chart-model="$lineChartModel"/>
    </div>
</div>
