<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Enums\FraisType;
use App\Http\Integrations\Scolarite\Requests\Annee\GetCurrentAnnneRequest;
use App\Http\Integrations\Scolarite\Requests\Filiere\GetFiliereRequest;
use App\Http\Integrations\Scolarite\Requests\Inscription\GetInscriptionRequest;
use App\Http\Integrations\Scolarite\Requests\Inscription\GetInscriptionsRequest;
use App\Http\Integrations\Scolarite\Requests\Option\GetOptionRequest;
use App\Models\Annee;
use App\Models\Frais;
use App\Models\Inscription;
use App\Models\Perception;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PerceptionCreateComponent extends Component
{
    use LivewireAlert;

    public $searchName;

    public $annee_id;
    public $user_id;
    public $raisons = [];
    public $fee_id;
    public $fee;
    public $montant;
    public $paid;
    public $paid_by;
    public $custom_property;
    public $inscription_id;
    public $eleveNom;
    public $classe_id;
    public $due_date;
    private $frais;
    private $inscriptions = [];
    public $inscription;

    public function mount()
    {
        $this->user_id = Auth::id();
        $this->annee_id = Annee::id();
        $this->due_date = Carbon::now()->format('Y-m-d');
        $this->inscription = new Inscription();
        $this->loadInscriptionFrais();

    }

    private function loadInscriptionFrais()
    {
        $this->frais = Frais::where(['annee_id' => $this->annee_id, 'type' => FraisType::inscription])->orderBy('nom')->get();
    }

    public function onSearchName()
    {

    }

    public function render()
    {
        $this->reloadData();
        return view('livewire.finance.perceptions.create',
            ['inscriptions' => $this->inscriptions, 'frais' => $this->frais])
            ->layout(AdminLayout::class, ['title' => 'Nouvelle Perception']);
    }

    private function reloadData()
    {
        $this->inscriptions = Inscription::getCurrentInscriptions();
       // $this->inscription_id = $this->inscription->id;

        if ($this->inscription_id == null) {
            $this->loadInscriptionFrais();
        } else {
            $this->chooseSuitableFrais();
        }

    }

    private function chooseSuitableFrais()
    {
        if ($this->inscription_id) {
           // $this->inscription = Inscription::find($this->inscription_id);
            $this->frais = Frais::
            where('annee_id', $this->annee_id)
                ->where('classable_type', 'like', '%Classe')
                ->where('classable_id', $this->classe_id)
                ->orderBy('nom')
                ->get();

            if (str_ends_with($this->inscription->classe->filierableType, 'Filiere')) {
                $filiere_id = $this->inscription->classe->filierable->id;
                $frais2 = Frais::
                where('annee_id', $this->annee_id)
                    ->where('classable_type', 'like', '%Filiere')
                    ->where('classable_id', $filiere_id)
                    ->orderBy('nom')
                    ->get();

                $this->frais = $this->frais->merge($frais2);

                $filiere2 = (new GetFiliereRequest($filiere_id))->send()->dto();
                if ($filiere2) {
                    $option_id = $filiere2->option_id;
                    $frais3 = Frais::
                    where('annee_id', $this->annee_id)
                        ->where('classable_type', 'like', '%Option')
                        ->where('classable_id', $option_id)
                        ->orderBy('nom')
                        ->get();

                    $this->frais = $this->frais->merge($frais3);

                    $option2 = (new GetOptionRequest($option_id))->send()->dto();
                    if ($option2) {
                        $section_id = $option2->section_id;

                        $frais4 = Frais::
                        where('annee_id', $this->annee_id)
                            ->where('classable_type', 'like', '%Section')
                            ->where('classable_id', $section_id)
                            ->orderBy('nom')
                            ->get();

                        $this->frais = $this->frais->merge($frais4);
                    }
                }
            }

            if (str_ends_with($this->inscription->classe->filierableType, 'Option')) {
                $option_id = $this->inscription->classe->filierable->id;
                $frais2 = Frais::
                where('annee_id', $this->annee_id)
                    ->where('classable_type', 'like', '%Option')
                    ->where('classable_id', $option_id)
                    ->orderBy('nom')
                    ->get();

                $this->frais = $this->frais->merge($frais2);

                $option2 = (new GetOptionRequest($option_id))->send()->dto();
                if ($option2) {
                    $section_id = $option2->section_id;

                    $frais4 = Frais::
                    where('annee_id', $this->annee_id)
                        ->where('classable_type', 'like', '%Section')
                        ->where('classable_id', $section_id)
                        ->orderBy('nom')
                        ->get();

                    $this->frais = $this->frais->merge($frais4);
                }
            }

            if (str_ends_with($this->inscription->classe->filierableType, 'Section')) {
                $section_id = $this->inscription->classe->filierable->id;
                $frais2 = Frais::
                where('annee_id', $this->annee_id)
                    ->where('classable_type', 'like', '%Section')
                    ->where('classable_id', $section_id)
                    ->orderBy('nom')
                    ->get();

                $this->frais = $this->frais->merge($frais2);
            }
        } else {
            $this->loadInscriptionFrais();
        }

    }

    public function eleveSelected()
    {
       // $this->inscription_id = intval($this->inscription_id);
        if ($this->inscription_id == null or $this->inscription_id == "") {
            $this->eleveNom = null;
            $this->inscription = null;
            $this->classe_id = null;

            //  $this->loadInscriptionFrais();
        } else {
            $this->inscription = Inscription::find($this->inscription_id);
            $this->eleveNom = $this->inscription->eleve->fullName;
            $this->classe_id = $this->inscription->classe->id;
        }
        $this->fee_id = null;
        $this->fee = null;
        $this->reloadData();
    }

    public function feeSelected()
    {
        $this->fee = Frais::find($this->fee_id);
        $this->montant = $this->fee->montant ?? null;
        $this->raisons = $this->fee != null ? $this->fee->frequence->children() : [];

    }

    public function addPerception()
    {
        $this->validate([
            'inscription_id' => $this->fee->type == FraisType::inscription ? 'nullable' : 'required',
            'fee_id' => 'required',
            'user_id' => 'required',
            'annee_id' => 'required',
            'due_date' => 'required',
            'paid' => 'nullable',
            'paid_by' => 'nullable',
        ]);

        try {
            $done = Perception::create(
                [
                    'user_id' => $this->user_id,
                    'frais_id' => $this->fee_id,
                    'inscription_id' => $this->inscription_id,
                    'custom_property' => $this->custom_property,
                    'annee_id' => $this->annee_id,
                    'montant' => $this->montant,
                    'due_date' => $this->due_date,
                    'paid' => $this->paid,
                    //'paid' => ($this->fee->type == FraisType::inscription and $this->paid == null) ? $this->montant : $this->paid,
                    'paid_by' => $this->paid_by,
                ]
            );

            if ($done) {
                //    $this->alert('success', "Frais imputé avec succès !");
                $this->flash('success', "Frais imputé avec succès !", [], route('scolarite.perceptions'));

            } else {
                $this->alert('warning', "Echec d'imputation de frais !");
            }
        } catch (Exception $exception) {
            $this->alert('error', "Echec d'imputation de frais déjà existante !");
        }
    }


}
