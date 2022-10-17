@php
    use App\Enum\InscriptionStatus;
    use App\Helpers\Helpers;use App\Models\Annee;
    $heads = [
            'NO.',
            '',
            'ELEVE',
            'SEXE',
            'AGE',
            'TELEPHONE',
            'EMAIL',
            'ADRESSE',
            'RESPONSABLE',
            'RELATION',
            ['Actions', 'no-export' => true, 'width' => 5],
        ];



    foreach ($eleves as $eleve){

            $btn1 = '<a href="' . "/admin/eleves/{$eleve->id}" . '" class="btn btn-success btn-sm m-1" title="Voir Élève"><i class="fa fa-eye"></i></a>';
            $btn2 = '<a hidden href="' . "/admin/eleves/{$eleve->id}/edit" . '" class="btn btn-warning btn-sm m-1" title="Edit"><i class="fa fa-edit"></i></a>';
            $btn3 = '<button hidden wire:click="deleteEleve('.$eleve->id.')"
                                                    title="supprimer" class="btn btn-danger  btn-sm m-1">
                                                <i class="fas fa-trash"></i>
                                            </button>';

        //    $badgeColor = Helpers::admissionStatusColor($inscription->status);
//if($profile_url == null)$profile_url =Helpers::fakePicsum($eleve->id, 100, 100);

            $data[] = [
                $eleve->id,
                '<img class="img-circle" style="width:50px; height:50px" src="'.$eleve->profile_url.'"></img>',
                $eleve->fullName,
                $eleve->sexe->value??'',
                $eleve->date_naissance->age??'',
                 '<a href="tel:'.$eleve->telephone.'">'.$eleve->telephone.'</a>',
                '<a href = "mailto:'.$eleve->email.'">'.$eleve->email.'</a>',
                $eleve->adresse,
                $eleve->responsable_eleve?->responsable?->nom??'',
                $eleve->responsable_eleve?->relation?->label()??'',
                '<nobr>' . $btn1 . $btn2. $btn3 . '</nobr>',
            ];

        }

        $config = [
            'data' => $data ?? [],
            'order' => [[1, 'asc']],
            'columns' => [['orderable' => true], ['orderable' => false], null, null, null, null, null, null, null, null,['orderable' => false]],
        ];
@endphp
@section('title')
    {{Str::upper('cenk')}} - élèves
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste d'élèves</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Élèves</li>
            </ol>
        </div>
    </div>

@stop
<div class="content mt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title d-flex">
                            {{--<a href="{{ route('admin.responsables.create') }}" title="ajouter"
                               class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>--}}
                        </div>
                        <div class="card-tools d-flex my-auto">

                            {{--  <a href="{{ route('admin.responsables.create') }}" title="ajouter"
                                 class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>
  --}}

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

