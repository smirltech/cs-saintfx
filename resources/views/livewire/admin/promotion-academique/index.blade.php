<div class="">

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">

                                <a href="{{ route('admin.promotions.create') }}" title="ajouter"
                                   class="btn btn-primary mr-2"><span
                                        class="fa fa-plus"></span></a>


                            </div>
                        </div>

                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>PROMOTION</th>
                                    <th>FILIERE</th>
                                    <th>FACULTE</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($promotions as $promotion)
                                    <tr>
                                        <td>{{ $promotion->code }}</td>
                                        <td>
                                            <a href="/admin/filieres/{{ $promotion->filiere->id }}">{{ $promotion->filiere->nom }}</a>
                                        </td>
                                        <td>
                                            <a href="/admin/facultes/{{ $promotion->filiere->faculte->id }}">{{ $promotion->filiere->faculte->nom }}</a>
                                        </td>
                                        <td>
                                            <div class="d-flex float-right">
                                                <a href="/admin/promotions/{{ $promotion->id }}" title="Voir"
                                                   class="btn btn-warning">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="/admin/promotions/{{ $promotion->id }}/edit" title="modifier"
                                                   class="btn btn-info  ml-2">
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                <button wire:click="deletePromotion({{ $promotion->id }})"
                                                        title="supprimer" class="btn btn-danger ml-2">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
    </div>
</div>
