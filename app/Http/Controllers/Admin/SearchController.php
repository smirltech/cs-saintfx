<?php

namespace App\Http\Controllers\Admin;

use App\Models\Demande;
use App\Services\Sagenet\SagenetService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'matricule' => 'nullable|digits:10',
        ]);

        $matricule = trim($request->matricule) ?? '';

        $demandes = Demande::where('matricule', $matricule)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('search', compact('demandes', 'matricule'))->with('title', 'Recherche');
    }

    public function print(string $matricule, string $grade, $filiere, SagenetService $sagenet)
    {

        $promotion = "{$grade} {$filiere}";

        $mention = $sagenet->mention()->show($matricule, $promotion)->object()->data[0];
        $cotations = $sagenet->cotation()->list($matricule, $promotion)->object()->data;


        return view('demandes.releve-print', compact('filiere', 'grade', 'mention', 'cotations'));
    }

}
