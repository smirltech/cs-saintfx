@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de consommables</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Consommables</li>
            </ol>
        </div>
    </div>

@stop
<div class="p-0 container-fluid ">
    <div class="row">
        <div class="col-12">
            <div class="card mb-7">
                <div class="card-header">
                    <div class="m-0 box_header">
                        <div class="main-title">
                            <h3 hidden class="m-0">{{__($title)}}</h3>
                        </div>
                        <div class="erning_btn d-flex float-right">
                            <button wire:click="$emit('showModal','roles.role-modal')"
                                    class="btn btn-outline-primary btn-sm"><i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="mb-3 card-body">
                    <!-- table-responsive -->
                    <div class="table-responsive-md">
                        <table class="table">
                            <thead class="table-header">
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{$role->display_name}}
                                    </td>
                                    <td>
                                        {{$role->description}}
                                    </td>
                                    <td>
                                        {{$role->display_permissions}}
                                    </td>
                                    <td>

                                        <button wire:click="$emit('showModal','roles.role-modal','{{ $role->id }}')"
                                                class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </button>

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
