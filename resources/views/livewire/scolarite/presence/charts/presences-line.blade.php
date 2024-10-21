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
        $presences = Presence::whereDate('date', $date->format('Y-m-d'))->where('status',PresenceStatus::PRESENT->value)->get();
    $absences = Presence::whereDate('date', $date->format('Y-m-d'))->where('status',PresenceStatus::ABSENT->value)->get();
    $malades = Presence::whereDate('date', $date->format('Y-m-d'))->where('status',PresenceStatus::MALADE->value)->get();

    $lineChartModel->addSeriesPoint('Présences', $date->format('d'), $presences->count());
    $lineChartModel->addSeriesPoint('Absences', $date->format('d'), $absences->count());
    $lineChartModel->addSeriesPoint('Malades', $date->format('d'), $malades->count());
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
