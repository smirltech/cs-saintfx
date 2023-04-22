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
