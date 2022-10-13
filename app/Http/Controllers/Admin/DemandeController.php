<?php

namespace App\Http\Controllers\Admin;

use App\Enum\DemandeStatus;
use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Notifications\DemandeApprovedNotification;
use App\Services\Sagenet\SagenetService;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Storage;
use Str;

class DemandeController extends Controller
{

    // build constructor and authorize resource
    public function __construct()
    {
        $this->authorizeResource(Demande::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {

        $demandes = Demande::where('faculte_code', Auth::user()->faculte->code)
            ->orderBy('id', 'desc')->get();

        $heads = [
            'ID',
            'Etudiant',
            'Faculté',
            'Grades',
            ['label' => 'Etat', 'width' => 20],
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];


        $data = [];
        foreach ($demandes as $demande) {

            $btnDetails = '<a href="' . route('demandes.show', $demande) . '" class="btn btn-xs btn-default mx-1" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye shadow-md"></i>
               </a>';

            if ($demande->isAccepted()) {
                $btnQr = '<a href="' . $demande->releve_location . '" class="btn btn-xs btn-default mx-1" title="Valider la demande"> <i class="fa fa-lg fa-fw fa-qrcode"></i><a>';
                $btnPrint = '<a href="' . $demande->generateRelevePrintLink() . '" class="btn btn-xs btn-default mx-1" title="Valider la demande"> <i class="fa fa-lg fa-fw fa-print"></i><a>';
            } else {
                $btnQr = '';
                $btnPrint = '';
            }

            $data[] = [
                $demande->id,
                "<strong> {$demande->nom} </strong></a><br> {$demande->matricule}",
                "{$demande->faculte_nom}",
                $demande->grades,
                '<span class="badge bg-' . $demande->status_variant . '">' . $demande->status_display . '</span>',
                '<nobr>' . $btnQr . $btnPrint . $btnDetails . '</nobr>',
            ];
        }


        $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, null, null, ['orderable' => false]],
        ];


        return view('demandes.index', [
            'heads' => $heads,
            'config' => $config,
            'title' => 'Demandes',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        return view('demandes.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Demande $demande
     * @return RedirectResponse
     */
    public function validateDemmande(Demande $demande)
    {

        # TODO 4. Valider la demande
        $demande->update([
            'status' => 'accepted',
        ]);
        # TODO 1. Generer le relevé de cotes


        # TODO 2. Envoyer un mail à l'étudiant
        $demande->notify(new DemandeApprovedNotification());

        # TODO 3. Envoyer un mail à l'administrateur de la faculté


        return Redirect::back()->with('success', 'La demande a été traitée avec succès');
    }

    public function showValidate(Demande $demande)
    {
        return view('demandes.validate', compact('demande'));
    }


    // download using dompdf

    public function download(string $grade, string $matirucle, Demande $demande, SagenetService $sagenet)
    {

        if ($matirucle != $demande->matricule) {
            abort(404);
        }

        $grade = Str::upper($grade);
        if (!in_array($grade, $demande->grades)) {
            abort(404);
        }

        if (!$demande->isAccepted()) {
            //TODO: uncomment this line to disable the download of and non accepted demandes
            // abort(404);
        }

        if (!$demande->isAccepted()) {
            //TODO: Ucomment this line to disable preview for non-accepted demandes
            //abort(404);
        }

        $promotion = "{$grade} {$demande->filiere}";
        $file = "{$grade}-ID{$demande->matricule}-{$demande->id}R";

        $mention = $sagenet->mention()->show($demande->matricule, $promotion)->object()->data[0];
        $cotations = $sagenet->cotation()->list($demande->matricule, $promotion)->object()->data;

        $qr_code = asset("storage/demandes/{$demande->id}/{$file}.png");
        if (!file_exists($qr_code)) {
            $html = QrCode::size(100)->style('round')->generate($demande->generateReleveLink($grade));
            Storage::put("public/demandes/{$demande->id}/{$file}.png", $html);
        }

        $pdf = PDF::loadView('demandes.releve-base', compact('demande', 'grade', 'qr_code', 'file', 'mention', 'cotations'));
        return $pdf->download("{$file}.pdf");
    }

    /**
     * Display the specified resource.
     *
     * @param Demande $demande
     * @return Application|Factory|View
     */
    public function show(Demande $demande, SagenetService $service)
    {
        $title = 'Details de la demande';
        $etudiant = null;
        $mentions = [];
        if ($demande->hasValidMatricule()) {
            $response = $service->etudiant()->show($demande->matricule);
            if ($response->ok()) {
                $etudiant = $response->object()->data;
                $mentions = $etudiant->mentions;
                if ($demande->status->isPending() or $demande->status->isUnavailable()) {
                    $demande->update([
                        'status' => DemandeStatus::available,
                    ]);
                }
            } elseif ($response->status() == 404) {
                $demande->update([
                    'status' => DemandeStatus::unavailable,
                ]);
            } else {
                $errorMessage = "Erreur {$response->status()} lors de la récupération de l\'étudiant";
            }
        } else {
            $demande->update([
                'status' => DemandeStatus::invalid,
            ]);
        }

        $errorMessage = $errorMessage ?? $demande->status_message;

        return \view('demandes.show', compact('demande', 'title', 'etudiant', 'errorMessage', 'mentions'));
    }

    public function send(string $grade, string $matirucle, Demande $demande, SagenetService $sagenet)
    {

    }


    public function preview(string $grade, string $matirucle, Demande $demande, SagenetService $sagenet)
    {
        if ($matirucle != $demande->matricule) {
            abort(404);
        }

        $grade = Str::upper($grade);
        if (!in_array($grade, $demande->grades)) {
            abort(404);
        }

        if (!$demande->isAccepted()) {
            //TODO: Ucomment this line to disable preview for non-accepted demandes
            //abort(404);
        }

        $promotion = "{$grade} {$demande->filiere}";
        $file = "{$grade}-ID{$demande->matricule}-{$demande->id}R";

        $mention = $sagenet->mention()->show($demande->matricule, $promotion)->object()->data[0];
        $cotations = $sagenet->cotation()->list($demande->matricule, $promotion)->object()->data;

        $qr_code = asset("storage/demandes/{$demande->id}/{$file}.png");
        if (!file_exists($qr_code)) {
            $html = QrCode::size(100)->style('round')->generate($demande->generateReleveLink($grade));
            Storage::put("public/demandes/{$demande->id}/{$file}.png", $html);
        }

        return view('demandes.releve-base', compact('demande', 'grade', 'qr_code', 'file', 'mention', 'cotations'));
    }

    public function print(string $grade, string $matirucle, Demande $demande, SagenetService $sagenet)
    {
        if ($matirucle != $demande->matricule) {
            abort(404);
        }

        $grade = Str::upper($grade);
        if (!in_array($grade, $demande->grades)) {
            abort(404);
        }

        if (!$demande->isAccepted()) {
            //TODO: Ucomment this line to disable preview for non-accepted demandes
            //abort(404);
        }

        $promotion = "{$grade} {$demande->filiere}";
        $file = "{$grade}-ID{$demande->matricule}-{$demande->id}R";

        $mention = $sagenet->mention()->show($demande->matricule, $promotion)->object()->data[0];
        $cotations = $sagenet->cotation()->list($demande->matricule, $promotion)->object()->data;

        $qr_code = asset("storage/demandes/{$demande->id}/{$file}.png");
        if (!file_exists($qr_code)) {
            $html = QrCode::size(100)->style('round')->generate($demande->generateReleveLink($grade));
            Storage::put("public/demandes/{$demande->id}/{$file}.png", $html);
        }

        return view('demandes.releve-print', compact('demande', 'qr_code', 'grade', 'file', 'mention', 'cotations'));
    }
}
