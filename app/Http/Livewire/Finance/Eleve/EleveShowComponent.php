<?php

namespace App\Http\Livewire\Finance\Eleve;

use App\Data\Annee;
use App\Http\Integrations\Scolarite\Requests\Annee\GetCurrentAnnneRequest;
use App\Http\Integrations\Scolarite\Requests\Filiere\GetFiliereRequest;
use App\Http\Integrations\Scolarite\Requests\Inscription\GetInscriptionRequest;
use App\Http\Integrations\Scolarite\Requests\Option\GetOptionRequest;
use App\Models\Frais;
use App\Models\Perception;
use App\View\Components\AdminLayout;
use Exception;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EleveShowComponent extends Component
{
    use LivewireAlert;

    public $fee_id;
    public $fee;
    public $montant;
    public $paid;
    public $paid_by;
    public $inscription_id;
    public $annee_id;
    public $custom_property;
    public $frais;
    public $user_id;
    public $raisons = [];
    public Perception $perception;
    public $eleveNom;
    public $annee_nom;
    protected $rules = [
        'montant' => 'required',

    ];
    protected $listeners = ['onModalClosed'];
    private Annee $annee_courante;
    private $inscription;
    private $eleve;

    public function mount(int $id)
    {
        $this->user_id = Auth::user()->id;
        $this->inscription_id = $id;
    }

    public function render()
    {
        $this->annee_courante = (new GetCurrentAnnneRequest())->send()->dto();
        $this->annee_id = $this->annee_courante->id;
        $this->inscription = (new GetInscriptionRequest($this->inscription_id))->send()->dto();
        $this->inscription_id = $this->inscription->id;
        // dd($this->inscription);
        $this->chooseSuitableFrais();
        $this->eleve = $this->inscription->eleve;

        $perceptionsRequest = Perception::where('annee_id', $this->annee_id)->where('inscription_id', $this->inscription_id);
        $perceptions = $perceptionsRequest->get();
        $perceptionsDues = $perceptionsRequest->sum("montant");
        $perceptionsPaid = $perceptionsRequest->sum("paid");

        return view('livewire.finance.eleves.show', [
            'annee_courante' => $this->annee_courante,
            'inscription' => $this->inscription,
            'eleve' => $this->eleve,
            'frais' => $this->frais,
            'fee' => $this->fee,
            'perceptions' => $perceptions,
            'perceptionsDues' => $perceptionsDues,
            'perceptionsPaid' => $perceptionsPaid,
        ])
            ->layout(AdminLayout::class, ['title' => '']);
    }

    private function chooseSuitableFrais()
    {
        $this->frais = Frais::
        where('annee_id', $this->annee_id)
            ->where('classable_type', 'like', '%Classe')
            ->where('classable_id', $this->inscription->classe->id)
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


    }


    public function feeSelected()
    {
        $this->fee = Frais::find($this->fee_id);
        $this->montant = $this->fee->montant ?? null;
        $this->raisons = $this->fee->frequence->children();
    }

    public function imputerFrais()
    {
        $this->validate([
            'inscription_id' => 'required',
            'fee_id' => 'required',
            'user_id' => 'required',
            'annee_id' => 'required',
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
                    'paid' => $this->paid,
                    'paid_by' => $this->paid_by,
                ]
            );

            if ($done) {
                $this->alert('success', "Frais imputé avec succès !");

                $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-perception-modal']);
            } else {
                $this->alert('warning', "Echec d'imputation de frais !");
            }
        } catch (Exception $exception) {
            $this->alert('error', "Echec d'imputation de frais déjà existante !");
        }


        $this->onModalClosed();

    }

    public function onModalClosed()
    {
        $this->clearValidation();
        // $this->reset(['nom', 'description','montant']);
    }

    public function getSelectedPerception(Perception $perception)
    {
        //  dd($perception);
        $this->perception = $perception;

        $this->montant = $perception->montant;
        $this->paid = $perception->paid ?? $perception->montant;
        $this->paid_by = $perception->paid_by;
        $this->fee = Frais::find($perception->frais_id);

        $this->inscription = (new GetInscriptionRequest($this->perception->inscription_id))->send()->dto();
        $this->inscription_id = $this->inscription->id;
        $this->eleve = $this->inscription->eleve;
        $this->eleveNom = $this->eleve->getNomComplet();
        $this->annee_courante = (new GetCurrentAnnneRequest())->send()->dto();
        $this->annee_nom = $this->annee_courante->nom;
    }

    public function payPerception()
    {
        $this->validate([
            'paid' => 'required',
        ]);
        $done = $this->perception->update([
            'paid' => $this->paid,
            'paid_by' => $this->paid_by,
        ]);

        if ($done) {
            $this->printIt();
            //Todo: generate receipt and print
            $this->alert('success', "Frais payé avec succès !");

            $this->dispatchBrowserEvent('closeModal', ['modal' => 'pay-perception-modal']);

        } else {
            $this->alert('warning', "Echec de paiement de frais !");
        }
    }

    private function printIt()
    {

        $this->dispatchBrowserEvent('printIt', ['elementId' => "factPrint", 'type' => 'html', 'maxWidth' => 301]);
    }
}
