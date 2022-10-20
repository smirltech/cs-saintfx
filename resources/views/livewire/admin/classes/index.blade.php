@section('title')
    {{Str::upper('cenk')}} - classes
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de classes</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Classes</li>
            </ol>
        </div>
    </div>

@stop
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
                                <a href="{{ route('admin.classes.create') }}" title="ajouter"
                                   class="btn btn-primary mr-2"><span
                                        class="fa fa-plus"></span></a>
                            </div>
                        </div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>CODE</th>
                                    <th>CLASSE</th>
                                    <th>SECTION/OPTION/FILIERE</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($classes as $classe)
                                    @php
                                        $parent_url = "";
                                            $classable = $classe->filierable;
                                            if($classable instanceof \App\Models\Filiere){
                                                $parent_url = "/admin/filieres/$classe->filierable_id";
                                            }else  if($classable instanceof \App\Models\Option){
                                                $parent_url = "/admin/options/$classe->filierable_id";
                                            }else  if($classable instanceof \App\Models\Section){
                                                $parent_url = "/admin/sections/$classe->filierable_id";
                                            }
                                    @endphp
                                    <tr>
                                        <td>{{ $classe->code }}</td>
                                        <td>{{ $classe->grade->label() }}</td>

                                        <td>
                                            <a href="{{$parent_url}}">{{ $classe->filierable->fullName }}</a>
                                        </td>
                                        <td>
                                            <div class="d-flex float-right">
                                                <a href="/admin/classes/{{ $classe->id }}" title="Voir"
                                                   class="btn btn-warning">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="/admin/classes/{{ $classe->id }}/edit" title="modifier"
                                                   class="btn btn-info  ml-2">
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                <button wire:click="deleteClasse({{ $classe->id }})"
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
