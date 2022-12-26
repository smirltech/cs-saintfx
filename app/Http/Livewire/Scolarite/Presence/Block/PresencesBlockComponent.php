<?php

namespace App\Http\Livewire\Scolarite\Presence\Block;

use App\Enums\ResultatType;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Inscription;
use App\Models\Presence;
use App\Models\Resultat;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class PresencesBlockComponent extends Component
{
    use LivewireAlert;
    use WithPagination;


    public Classe $classe;
    public $inscriptions = [];
    //public $resultats = [];
    public Presence $presence;
    public Inscription $inscription;

    protected $rules = [
        'presence.date' => 'required',
        'presence.observation' => 'nullable',

    ];

    protected $listeners = ['onModalClosed'];

    public function mount(Classe $classe)
    {

        //$this->resultatType = ResultatType::p1;
     //   $this->selectResultatType();
        $this->classe = $classe;
        $this->initPresence();
     //   $this->initInscription();
        // $this->loadData();

    }

/*    public function selectResultatType()
    {
        $this->resultatType = ResultatType::from($this->resultatTypeValue);
        //  $this->loadData();
    }*/

    private function initPresence()
    {
        $this->presence = new Presence();
    }

 /*   private function initInscription()
    {
        $this->inscription = new Inscription();
    }*/

 /*   public function selectInscription($id)
    {
        $this->inscription = Inscription::find($id);
        $temp = $this->inscription->resultats()->where('custom_property', $this->resultatType)->first();
        if ($temp != null) {
            $this->resultat = $temp;
        } else {
            $this->initResultat();
        }
        //  $this->loadData();
    }*/

    public function render()
    {
        $this->loadData();
        return view('livewire.scolarite.presences.blocks.list');
    }

    public function loadData()
    {
        $this->inscriptions = $this->classe->inscriptions;
    }

   /* public function updateResultat()
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
    }*/

    public function onModalClosing($modalId)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $modalId]);
        $this->initPresence();
      //  $this->initInscription();
        $this->loadData();

        //$this->reset(['nom', 'description', 'montant', 'classable_type', 'classable_id']);
    }

    public function printIt()
    {
        $this->loadData();
        $this->dispatchBrowserEvent('printIt', ['elementId' => "presencesPrint", 'type' => 'html', 'maxWidth' => '100%']);
    }
}
