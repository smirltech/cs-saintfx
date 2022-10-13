@php
    use App\Enum\AdmissionStatus;
    use App\Models\Annee;
    $heads = [
            'NO.',
            'ETUDIANT',
            'SEXE',
            '% DIPLOME',
            'OPTION',
            'PROMOTION',
            'STATUS',
            'DEPUIS LE',
            ['Actions', 'no-export' => true, 'width' => 5],
        ];



    foreach ($admissions->sortBy(fn ($q) => $q->etudiant->fullname) as $admission){

            $btn1 = '<a href="' . "/admin/etudiants/{$admission->etudiant_id}" . '" class="btn btn-success btn-sm m-1" title="Voir Étudiant"><i class="fa fa-eye"></i></a>';
            $btn2 = '<a href="' . "/admin/admissions/{$admission->id}/edit" . '" class="btn btn-warning btn-sm m-1" title="Edit"><i class="fa fa-edit"></i></a>';
            $btn3 = '<button hidden wire:click="deleteAdmission('.$admission->id.')"
                                                    title="supprimer" class="btn btn-danger  btn-sm m-1">
                                                <i class="fas fa-trash"></i>
                                            </button>';

            $badgeColor = \App\Helpers\Helpers::admissionStatusColor($admission->status);

            $data[] = [
                 $admission->code,
                $admission->etudiant->fullname,
               $admission->etudiant->sexe->value??'',
                $admission->etudiant->diplome->pourcentage??'',
                $admission->etudiant->diplome->option??'',
                $admission->promotion->code,
               '<span class="badge bg-gradient-'.$badgeColor.'">'. $admission->status->label().'</span>',
                $admission->created_at->format('d/m/Y'),
                '<nobr>' . $btn1 . $btn2. $btn3 . '</nobr>',
            ];

        }

        $config = [
            'data' => $data ?? [],
            'order' => [[1, 'asc']],
            'columns' => [['orderable' => true], null, null, null, null, null, null, null,['orderable' => false]],
        ];
@endphp
@section('title')
    {{Str::upper('UPL admissions')}} {{date('d-m-Y')}}
@endsection
<div class="content mt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title d-flex">
                            <a href="{{ route('admin.admissions.create') }}" title="ajouter"
                               class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>
                        </div>
                        <div class="card-tools d-flex my-auto">

                            <a href="{{ route('admin.admissions.create') }}" title="ajouter"
                               class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>


                        </div>
                    </div>

                    <div class="mb-3 card-body">
                        <div class="table-responsive m-b-40">
                            <x-adminlte-datatable id="table7" :heads="$heads" theme="light" :config="$config" striped
                                                  hoverable with-buttons/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

