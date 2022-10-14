<div class="">

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">

                    <div class="card-tools">
                        <a href="/admin/filieres/{{ $filiere->id }}/edit" title="modifier"
                           class="btn btn-primary btn-sm ml-2">
                            <i class="fas fa-pen"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label>Nom : </label>
                            {{ $filiere->nom }}
                        </div>
                        <div class="col">
                            <label>Code : </label>
                            {{ $filiere->code }}
                        </div>
                        <div class="col">
                            <label>Faculté : </label>
                            <a href="/admin/facultes/{{ $filiere->faculte->id }}">{{ $filiere->faculte->nom }}</a>

                        </div>
                    </div>

                    <div class="mt-4">
                        <label>Description : </label>
                        {{ $filiere->description }}
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="m-0">Promotions</h3>
                    </div>
                    <div class="card-tools d-flex my-auto">
                        <a href="{{ route('admin.promotions.create') }}" title="ajouter"
                           class="btn btn-primary mr-2"><span
                                class="fa fa-plus"></span></a>
                    </div>
                </div>

                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>PROMOTION</th>
                            <th style="width: 200px">CODE</th>
                            <th style="width: 100px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($filiere->promotions as $promotion)
                            <tr>
                                <td>
                                    <a href="/admin/promotions/{{ $promotion->id }}" class="">
                                        {{ $promotion->grade->label() }}
                                    </a>

                                </td>

                                <td>{{ $promotion->code }}</td>
                                <td>
                                    <div class="d-flex float-right">
                                        <a href="/admin/promotions/{{ $promotion->id }}" title="Voir"
                                           class="btn btn-warning">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
