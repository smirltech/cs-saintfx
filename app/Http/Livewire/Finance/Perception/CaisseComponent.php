<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Inscription;
use App\Models\Perception;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Str;

class CaisseComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $perceptions = [];
    public $inscriptions = [];
    public $inscription;
    public $perception;
    public $searchTerm = '';
    public $annee;
    public $fee;

    protected $rules = [
        'perception.paid' => 'nullable',
        'perception.paid_by' => 'nullable',
    ];

    public function mount()
    {
        $this->authorize('viewAny', Perception::class);
        $this->annee = Annee::encours();
    }

    public function render()
    {

        return view('livewire.finance.perceptions.caisse.caisse')
            ->layout(AdminLayout::class);
    }

    public function getSelectedInscription($id)
    {
        $this->inscription = Inscription::find($id);
        $this->perceptions = $this->inscription->perceptionsEncours;
    }

    public function getSelectedPerception($id)
    {
        $this->perception = Perception::find($id);
        $this->fee = $this->perception->frais;
        //  dd($this->perception);
    }

    public function clearSelection()
    {
        $this->inscription = null;
        $this->perceptions = [];
        $this->perception = null;
        $this->fee = null;
    }

    public function clearSearch()
    {
        $this->searchTerm = '';
        $this->inscription = null;
        $this->perceptions = [];
        $this->inscriptions = [];
        $this->perception = null;
        $this->fee = null;
    }


    public function searchInscription()
    {
        $terms = trim($this->searchTerm);

        if ($terms != null && Str::length($terms) > 1) {
            $this->inscriptions = Inscription::where('annee_id', $this->annee->id)
                ->whereHas('eleve', function ($q) use ($terms) {
                    $q->where('nom', 'like', '%' . $terms . '%');

                })
                ->get()
                ->where('perceptions_encours_count', '>', 0);
        } else {
            $this->inscriptions = [];
        }

    }

    public function payFacture()
    {
        $this->validate();
        $done = $this->perception->save();

        if ($done) {
            $this->onModalClosed('paiement-facture');
            $this->alert('success', "Facture payée avec succès !");
            $this->printIt();
        } else {
            $this->alert('warning', "Echec de paiement de facture !");
        }
    }

    // paiement et impression facture


    private function printIt()
    {

        $this->dispatchBrowserEvent('printIt', ['elementId' => "factPrint", 'type' => 'html', 'maxWidth' => 301]);
    }

}
