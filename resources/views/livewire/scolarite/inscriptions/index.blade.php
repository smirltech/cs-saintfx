@php
    use App\Enums\InscriptionStatus;
    use App\Enums\Sexe;use App\Helpers\Helpers;use App\Models\Annee;
    $heads = [
            'NO.',
            '',
            'ELEVE',
            'SEXE',
            'CLASSE',
            'STATUS',
            'DEPUIS LE',
            ['Actions', 'no-export' => true, 'width' => 5],
        ];



    foreach ($inscriptions->sortBy(fn ($q) => $q->eleve->fullName) as $inscription){

            $btn1 = '<a href="' . route("scolarite.eleves.show",$inscription->eleve). '" class="btn btn-success btn-sm m-1" title="Voir Élève"><i class="fa fa-eye"></i></a>';

            $badgeColor = Helpers::admissionStatusColor($inscription->status);

            $data[] = [
                 $inscription->code,
                 '<img class="img-circle" style="width:50px; height:50px" src="'.$inscription->eleve->profile_url.'"></img>',

                $inscription->eleve->fullName,
               $inscription->eleve->sexe->value??'',

                $inscription->classe->code,
               '<a href="'.route('scolarite.inscriptions.status',['status'=>$inscription->status->name]).'"><span class="badge bg-gradient-'.$badgeColor.'">'. $inscription->status->label(Sexe::f).'</span></a>',
                $inscription->created_at->format('d/m/Y'),
                '<nobr>' . $btn1. '</nobr>',
            ];

        }

        $config = [
            'data' => $data ?? [],
            'order' => [[1, 'asc']],
            'columns' => [['orderable' => true],null, null, null, null, null, null,['orderable' => false]],
        ];
@endphp
@section('title')
     - inscriptions {{date('d-m-Y')}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">ELEVES - {{$annee_courante->nom}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Inscriptions</li>
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
                            <a href="{{ route('scolarite.inscriptions.create') }}" title="ajouter"
                               class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>
                        </div>
                        <div class="card-tools d-flex my-auto">

                            <a href="{{ route('scolarite.inscriptions.create') }}" title="ajouter"
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

