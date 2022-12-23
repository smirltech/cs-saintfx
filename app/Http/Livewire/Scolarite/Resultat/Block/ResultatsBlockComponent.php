<?php

namespace App\Http\Livewire\Scolarite\Resultat\Block;

use App\Enums\ResultatType;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Inscription;
use App\Models\Resultat;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ResultatsBlockComponent extends Component
{
    use LivewireAlert;
    use WithPagination;


    public Classe $classe;
    public $inscriptions = [];
    //public $resultats = [];
    public Resultat $resultat;
    public Inscription $inscription;
    public ResultatType $resultatType;
    public $resultatTypeValue;

    protected $rules = [
        'resultat.pourcentage' => 'required',
        'resultat.place' => 'required',
        'resultat.conduite' => 'nullable',
    ];

    protected $listeners = ['onModalClosed'];

    public function mount(Classe $classe)
    {
        $this->resultatTypeValue = ResultatType::p1->value;
        //$this->resultatType = ResultatType::p1;
        $this->selectResultatType();
        $this->classe = $classe;
        $this->initResultat();
        $this->initInscription();
        // $this->loadData();

    }

    public function selectResultatType()
    {
        $this->resultatType = ResultatType::from($this->resultatTypeValue);
        //  $this->loadData();
    }

    private function initResultat()
    {
        $this->resultat = new Resultat();
        $this->resultat->annee_id = Annee::id();
        $this->resultat->classe_id = $this->classe->id;
        //if($this->re)

    }

    private function initInscription()
    {
        $this->inscription = new Inscription();
    }

    public function selectInscription($id)
    {
        $this->inscription = Inscription::find($id);
        $temp = $this->inscription->resultats()->where('custom_property', $this->resultatType)->first();
        if ($temp != null) {
            $this->resultat = $temp;
        } else {
            $this->initResultat();
        }
        //  $this->loadData();
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.scolarite.resultats.blocks.list');
    }

    public function loadData()
    {
        $this->inscriptions = $this->classe->inscriptionsAsOfPlaceOfResultats($this->resultatType);
    }

    public function updateResultat()
    {
        $this->validate();
        $this->resultat->custom_property = $this->resultatType->value;
        $this->resultat->annee_id = Annee::id();
        $this->resultat->classe_id = $this->classe->id;
        $this->resultat->inscription_id = $this->inscription->id;
        //$this->resultat->conduite = Conduite::b->name;

        $done = Resultat::updateOrCreate(
            [
                'inscription_id' => $this->resultat->inscription_id,
                'classe_id' => $this->resultat->classe_id,
                'annee_id' => $this->resultat->annee_id,
                'custom_property' => $this->resultat->custom_property,
            ],
            [
                'pourcentage' => $this->resultat->pourcentage,
                'place' => $this->resultat->place,
                'conduite' => $this->resultat->conduite,
            ]
        );

        if ($done) {
            $this->onModalClosing('update-resultat');
            $this->alert('success', "Résultat modifié avec succès !");
        } else {
            $this->alert('warning', "Echec de modification de résultat !");
        }
    }

    public function onModalClosing($modalId)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $modalId]);
        $this->initResultat();
        $this->initInscription();
        $this->loadData();

        //$this->reset(['nom', 'description', 'montant', 'classable_type', 'classable_id']);
    }

    public function printIt()
    {
        $this->loadData();
        $this->dispatchBrowserEvent('printIt', ['elementId' => "resultatsPrint", 'type' => 'html', 'maxWidth' => '100%']);
    }
}
