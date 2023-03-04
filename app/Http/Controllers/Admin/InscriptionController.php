<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInscriptionRequest;
use App\Imports\InscriptionsImport;
use App\Models\Annee;
use App\Models\Inscription;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class InscriptionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Inscription::class);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $annees = Annee::all();


        return view(view: 'scolarite.inscriptions.import', data: [
            'annees' => $annees,
        ])->with('title', 'Importation des délibérations');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInscriptionRequest $request
     * @return RedirectResponse
     */
    public function store(StoreInscriptionRequest $request)
    {

        try {
            InscriptionsImport::build(annee: $request->annee)->import(file: $request->fiche->getRealPath());
            return Redirect::route(route: 'scolarite.inscriptions.index')->with('success', 'Les inscriptions ont été importées avec succès');
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());

        }
    }

    /*    protected function resourceAbilityMap()
        {
            return [
                'index' => 'viewAny',
                'show' => 'view',
                'create' => 'create',
                'store' => 'create',
                'edit' => 'update',
                'update' => 'update',
                'destroy' => 'delete',
                'print' => 'print'
            ];
        }*/
}
