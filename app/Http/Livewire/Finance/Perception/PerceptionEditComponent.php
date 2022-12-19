<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Enums\FraisType;
use App\Http\Integrations\Scolarite\Requests\Annee\GetCurrentAnnneRequest;
use App\Http\Integrations\Scolarite\Requests\Filiere\GetFiliereRequest;
use App\Http\Integrations\Scolarite\Requests\Inscription\GetInscriptionRequest;
use App\Http\Integrations\Scolarite\Requests\Inscription\GetInscriptionsRequest;
use App\Http\Integrations\Scolarite\Requests\Option\GetOptionRequest;
use App\Models\Frais;
use App\Models\Perception;
use App\View\Components\AdminLayout;
use Exception;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PerceptionEditComponent extends Component
{
    use LivewireAlert;

    public $perception;
    public $annee_id;
    public $user_id;
    public $raisons = [];
    public $fee_id;
    public $fee;
    public $montant;
    public $due_date;
    public $paid;
    public $paid_by;
    public $custom_property;
    public $inscription_id;
    public $eleveNom;
    public $classe_id;
    public $annee_nom;
    private $annee;
    private $frais;
    private $inscriptions = [];
    private $inscription;

    public function mount(Perception $perception)
    {
        $this->user_id = Auth::id();
        $this->annee = (new GetCurrentAnnneRequest())->send()->dto();
        $this->annee_id = $this->annee->id;
        $this->annee_nom = $this->annee->nom;
        $this->perception = $perception;
        $this->montant = $perception->montant;
        $this->due_date = $perception->due_date;
        $this->paid = $perception->paid;
        $this->paid_by = $perception->paid_by;
        $this->fee_id = $perception->frais_id;
        $this->inscription_id = $perception->inscription_id;
        $this->custom_property = $perception->custom_property;

        if ($this->inscription_id) {
            $this->inscription = (new GetInscriptionRequest($this->inscription_id))->send()->dto();
            $this->eleveNom = $this->inscription->eleve->getNomComplet();
            $this->classe_id = $this->inscription->classe->id;
        }


        $this->fee = Frais::find($this->fee_id);
        $this->raisons = $this->fee != null ? $this->fee->frequence->children() : [];


        $this->loadInscriptionFrais();
    }

    private function loadInscriptionFrais()
    {
        $this->frais = Frais::where(['annee_id' => $this->annee_id, 'type' => FraisType::inscription])->orderBy('nom')->get();
    }

    public function render()
    {
        $this->reloadData();
        return view('livewire.admin.perceptions.edit',
            ['annee' => $this->annee, 'inscription' => $this->inscription, 'inscriptions' => $this->inscriptions, 'frais' => $this->frais])
            ->layout(AdminLayout::class, ['title' => 'Modifier Perception']);
    }

    private function reloadData()
    {
        $this->inscriptions = (new GetInscriptionsRequest())->send()->dto();
        $this->inscription_id = (int)$this->inscription_id;

        if ($this->inscription_id) {
            $this->inscription = (new GetInscriptionRequest($this->inscription_id))->send()->dto();
            $this->eleveNom = $this->inscription->eleve->getNomComplet();
            $this->classe_id = $this->inscription->classe->id;
        }

        if ($this->inscription_id == null) {
            $this->loadInscriptionFrais();
        } else {

            $this->chooseSuitableFrais();
        }

    }

    private function chooseSuitableFrais()
    {
        if ($this->inscription_id) {
            $this->inscription = (new GetInscriptionRequest($this->inscription_id))->send()->dto();
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

    public function feeSelected()
    {
        $this->fee = Frais::find($this->fee_id);
        $this->montant = $this->fee->montant ?? null;
        $this->raisons = $this->fee != null ? $this->fee->frequence->children() : [];

    }

    public function editAndPrintPerception()
    {

        $this->editPerception();
    }

    public function editPerception()
    {

        try {
            $done = $this->doTheEdit();


            if ($done) {
                // $this->alert('success', "Facture modifiée avec succès !");
                $this->flash('success', "Facture modifiée avec succès !", [], route('admin.perceptions'));

            } else {
                $this->alert('warning', "Echec de modofication de facture !");
            }
        } catch (Exception $exception) {
            $this->alert('error', "Echec de modification de facture pour la fréquence déjà existante !");
        }
    }

    private function doTheEdit()
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

        return $this->perception->update(
            [
                'frais_id' => $this->fee_id,
                'inscription_id' => $this->inscription_id,
                'custom_property' => $this->custom_property,
                'montant' => $this->montant,
                'due_date' => $this->due_date,
                'paid' => $this->paid,
                // 'paid' => ($this->fee->type == FraisType::inscription and $this->paid == null) ? $this->montant : $this->paid,
                'paid_by' => $this->paid_by,
            ]
        );

    }

    public function printIt()
    {
        try {
            $this->doTheEdit();
        } catch (Exception $ex) {
        }
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'recu-modal']);
        $this->dispatchBrowserEvent('printIt', ['elementId' => "factPrint", 'type' => 'html', 'maxWidth' => 301]);
    }
}
