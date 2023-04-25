@php
    use App\Models\Annee;use App\Models\Depense;use App\Models\Revenu;use Asantibanez\LivewireCharts\Models\ColumnChartModel;use Asantibanez\LivewireCharts\Models\PieChartModel;
@endphp
<x-admin-layout>
    <div class="pb-3"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row g-2">
                    @foreach ($boxes as $box)
                        <div class="col-md-3" bis_skin_checked="1">
                            <div class="info-box" bis_skin_checked="1">
                                    <span class="info-box-icon  bg-{{ $box['theme'] }} elevation-1">
                                        <i class="{{ $box['icon'] }}"></i></span>
                                <div class="info-box-content" bis_skin_checked="1">
                                    <span class="info-box-text">{{ $box['text'] }}</span>
                                    <span class="info-box-number">
                                            {{ $box['title'] }}
                                        </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                @php
                    $columnChartModel = (new ColumnChartModel())->multiColumn();
                               $columnChartModel->setTitle(Annee::encours()->nom)
                               ->addSeriesColumn('Peter', '2022-02-27', 20)
                               ->addSeriesColumn('Peter', '2022-02-28', 40)
                               ->addSeriesColumn('Harry', '2022-02-26', 15)
                               ->addSeriesColumn('Harry', '2022-03-02', 35)
                               ->addSeriesColumn('Sarah', '2022-02-02', 15)
                               ->addSeriesColumn('Sarah', '2022-03-02', 35);
                @endphp
                <div class="card">
                    <div class="card-header">
                        Revevues vs Depenses
                    </div>
                    <div class="card-body" style="height: 350px;">
                        <livewire:livewire-column-chart
                            :column-chart-model="$columnChartModel"
                        />
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                @php
                    $pieChartModel = (new PieChartModel());
                               $pieChartModel->setTitle(Annee::encours()->nom)
                               ->addSlice('Revenues', Revenu::total(), '#00ff00')
                               ->addSlice('Depenses', Depense::total(), '#ff0000');
                @endphp
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                Comparaison Revenues vs Depenses
                            </div>
                            <div class="col-md-6">
                                <x-form::select
                                    wire:model="annee_id"
                                    :options="Annee::all()"
                                />
                            </div>
                        </div>


                    </div>
                    <div class="card-body" style="height: 350px;">
                        <livewire:livewire-pie-chart
                            key="{{ $pieChartModel->reactiveKey() }}"
                            :pie-chart-model="$pieChartModel"
                        />
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <x-charts.male-female-donut-chart/>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <livewire:dashboard.components.frais-due-card/>
            </div>


            {{--        <!-- dashbox -->
                    <div class="col-12 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h3><i class="fa fa-star"></i> Les plus rentables</h3>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>TITLE</th>
                                        <th>SEANCES</th>
                                        <th>REVENU</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($top_movies as $movie)
                                        <tr>
                                            <td>
                                                <div>{{ $loop->iteration }}</div>
                                            </td>
                                            <td>
                                                <div>
                                                    <a href="{{ route('admin.movies.show',$movie) }}">{{
                                                    $movie->title }}</a>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{$movie->programs->count()}}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="main__table-text main__table-text--rate"><i
                                                        class="icon ion-ios-cash"></i>
                                                    ${{$movie->getRevenues()}}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end dashbox -->

                    <!-- dashbox -->
                    <div class="col-12 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h3><i class="fa fa-film"></i> Les plus recents</h3>
                            </div>

                            <div class="card-body">
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>TITLE</th>
                                        <th>SORTIE</th>
                                        <th>SEANCES</th>
                                        <th>REVENUE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($latest_movies as $movie)
                                        <tr>
                                            <td>
                                                <div class="main__table-text">{{ $loop->iteration }}</div>
                                            </td>
                                            <td>
                                                <div class="main__table-text"><a href="{{ route('admin.movies.show',$movie) }}">{{
                                                    $movie->title }}</a></div>
                                            </td>

                                            <td>
                                                <div class="main__table-text main__table-text--green">{{
                                                $movie->release_date }}</div>
                                            </td>
                                            <td>
                                                <div class="main__table-text">{{$movie->programs->count()}}</div>
                                            </td>
                                            <td>
                                                <div class="main__table-text main__table-text--rate"><i
                                                        class="icon ion-ios-cash"></i>
                                                    ${{$movie->getRevenues()}}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end dashbox -->--}}
        </div>
    </div>
</x-admin-layout>
