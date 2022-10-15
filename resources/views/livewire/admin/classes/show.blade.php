@php
    use App\Enum\InscriptionStatus;use App\Helpers\Helpers;

 /*   $heads = [
            'NO.',
            'ETUDIANT',
            'SEXE',
            '% DIPLOME',
            'OPTION',
            'STATUS',
            'DEPUIS LE',
            ['Actions', 'no-export' => true, 'width' => 5],
        ];*/

    /*foreach ($admissions->sortBy(fn ($q) => $q->etudiant->fullname) as $admission){

            $btn1 = '<a href="' . "/admin/etudiants/{$admission->etudiant_id}" . '" class="btn btn-success btn-sm m-1" title="Voir Étudiant"><i class="fa fa-eye"></i></a>';
            $btn2 = '<a href="' . "/admin/admissions/{$admission->id}/edit" . '" class="btn btn-warning btn-sm m-1" title="Edit"><i class="fa fa-edit"></i></a>';
            $btn3 = '<button hidden wire:click="deleteAdmission('.$admission->id.')"
                                                    title="supprimer" class="btn btn-danger  btn-sm m-1">
                                                <i class="fas fa-trash"></i>
                                            </button>';

            $badgeColor = Helpers::admissionStatusColor($admission->status);

            $data[] = [
                 $admission->code,
                $admission->etudiant->fullname,
               $admission->etudiant->sexe->value??'',
                $admission->etudiant->diplome->pourcentage??'',
                $admission->etudiant->diplome->option??'',

               '<span class="badge bg-gradient-'.$badgeColor.'">'. $admission->status->label().'</span>',
                $admission->created_at->format('d/m/Y'),
                '<nobr>' . $btn1 . $btn2. $btn3 . '</nobr>',
            ];

        }*/

       /* $config = [
            'data' => $data ?? [],
            'order' => [[1, 'asc']],
            'columns' => [['orderable' => true], null, null, null, null, null, null,['orderable' => false]],
        ];*/

@endphp
@section('title')
    {{Str::upper('cenk')}} - classe - {{$classe->code}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">{{$classe->grade->label()}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.classes') }}">Classes</a></li>
                <li class="breadcrumb-item active">{{$classe->grade}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <a href="/admin/classes/{{ $classe->id }}/edit" title="modifier"
                           class="btn btn-primary btn-sm ml-2">
                            <i class="fas fa-pen"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-6">
                            <label>Grade : </label>
                            {{ $classe->grade->label() }}
                        </div>
                        <div class="col-md-4 col-sm-6 col-6">
                            <label>Code : </label>
                            {{ $classe->code }}
                        </div>
                        <div class="col-md-4 col-sm-12 col-12">
                            <label>Filière : </label>
                           {{-- <a href="/admin/filieres/{{ $classe->filiere->id }}">{{  $promotion->filiere->nom }}</a>
--}}
                        </div>
                    </div>

                    <div class="row d-flex mt-2">

                        <div class="col-md-3 col-sm-6 col-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-info rounded p-2"><i
                                        class="fa fa-users align-middle"></i></div>
                                <div class="ml-1 d-flex flex-column">
                                    <span class=""></span>
                                    <span class=""><strong></strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded p-2"><i
                                        class="fa fa-users align-middle"></i></div>
                                <div class="ml-1 d-flex flex-column">
                                    <span class=""></span>
                                    <span class=""><strong></strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger rounded p-2"><i
                                        class="fa fa-users align-middle"></i></div>
                                <div class="ml-1 d-flex flex-column">
                                    <span class=""></span>
                                    <span class=""><strong></strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning rounded p-2"><i
                                        class="fa fa-users align-middle"></i></div>
                                <div class="ml-1 d-flex flex-column">
                                    <span class=""></span>
                                    <span class=""><strong></strong></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="m-0">Liste d'inscriptions</h4>
                    </div>
                    <div class="card-tools d-flex my-auto">

                       {{-- <a href="{{ route('admin.admissions.create') }}" title="ajouter"
                           class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>--}}


                    </div>
                </div>

                <div class="card-body p-0 table-responsive">
                   {{-- <x-adminlte-datatable id="table7" :heads="$heads" theme="light" :config="$config" striped
                                          hoverable with-buttons/>--}}
                </div>
            </div>
        </div>
    </div>
</div>
