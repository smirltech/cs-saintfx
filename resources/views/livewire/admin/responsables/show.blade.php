@php
    use App\Enum\InscriptionStatus;
    use App\Helpers\Helpers;use App\Models\Annee;
    $heads = [
            'NO.',
            'ELEVE',
            'SEXE',
            'AGE',
            'TELEPHONE',
            'EMAIL',
            'RELATION',
            ['Actions', 'no-export' => true, 'width' => 5],
        ];



    foreach ($responsable->responsable_eleves as $responsable_eleve){

            $btn1 = '<a href="' . "/admin/eleves/{$responsable_eleve->eleve->id}" . '" class="btn btn-success btn-sm m-1" title="Voir Élève"><i class="fa fa-eye"></i></a>';
            $btn2 = '<a hidden href="' . "/admin/eleves/{$responsable_eleve->eleve->id}/edit" . '" class="btn btn-warning btn-sm m-1" title="Edit"><i class="fa fa-edit"></i></a>';
            $btn3 = '<button hidden wire:click="deleteEleve('.$responsable_eleve->eleve->id.')"
                                                    title="supprimer" class="btn btn-danger  btn-sm m-1">
                                                <i class="fas fa-trash"></i>
                                            </button>';

        //    $badgeColor = Helpers::admissionStatusColor($inscription->status);

            $data[] = [
                $responsable_eleve->eleve->id,
                $responsable_eleve->eleve->fullName,
                $responsable_eleve->eleve->sexe->value??'',
                $responsable_eleve->eleve->date_naissance->age??'',
                '<a href="tel:'.$responsable_eleve->eleve->telephone.'">'.$responsable_eleve->eleve->telephone.'</a>',
                '<a href = "mailto:'.$responsable_eleve->eleve->email.'">'.$responsable_eleve->eleve->email.'</a>',
                $responsable_eleve?->relation?->reverse($responsable_eleve->eleve->sexe)??'',
                '<nobr>' . $btn1 . $btn2. $btn3 . '</nobr>',
            ];

        }

        $config = [
            'data' => $data ?? [],
            'order' => [[1, 'asc']],
            'columns' => [['orderable' => true], null, null, null, null, null, null,['orderable' => false]],
        ];
@endphp
@section('title')
    {{Str::upper('cenk')}} - responsable - {{$responsable->nom}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">{{$responsable->nom}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.responsables') }}">Responsables</a></li>
                <li class="breadcrumb-item active">{{$responsable->nom}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                {{--<div class="card-header">

                    <div class="card-tools">

                    </div>
                </div>--}}
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label>Nom : </label>
                            {{ $responsable->nom }}
                        </div>
                        <div class="col">
                            <label>Sexe : </label>
                            {{ $responsable->sexe->value }}
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Phone : </label>
                            <a href="tel:{{ $responsable->telephone }}">{{ $responsable->telephone }}</a>
                        </div>
                        <div class="col">
                            <label>E-mail : </label>
                            <a href="mailto:{{ $responsable->email }}">{{ $responsable->email }}</a>
                        </div>
                        <div class="col">
                            <label>Adresse : </label>
                            {{ $responsable->adresse }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="m-0">Enfants</h3>
                    </div>
                    <div class="card-tools d-flex my-auto">
                        {{--<button type="button"
                                class="btn btn-primary  ml-2" data-toggle="modal"
                                data-target="#add-classe-modal"><span
                                class="fa fa-plus"></span></button>--}}
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive m-b-40">
                        <x-adminlte-datatable id="table7" :heads="$heads" theme="light" :config="$config" striped
                                              hoverable with-buttons/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
