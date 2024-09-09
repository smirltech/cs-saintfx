<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Inscription;
use App\Models\Perception;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Str;

class CaisseComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $perceptions = [];
    public Collection|array $inscriptions = [];
    public $inscription;
    public $perception;
    public $searchTerm = '';
    public $annee;
    public $fee;
    public Collection $classes;
    public string $classe_id = '';
    public string $inscription_id = '';
    public Collection $inscriptionOptions;
    protected $rules = [
        'perception.paid' => 'nullable',
        'perception.paid_by' => 'nullable',
    ];

    public function mount(): void
    {
        $this->authorize('viewAny', Perception::class);
        $this->annee = Annee::encours();
        $this->classes = Classe::all();
        $this->inscriptionOptions = Inscription::where('annee_id', $this->annee->id)->get()
            ->where('perceptions_encours_count', '>', 0);
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.finance.perceptions.caisse.caisse')
            ->layout(AdminLayout::class);
    }

    public function updatedInscriptionId($value): void
    {
        $this->inscriptions = Inscription::whereId($value)->get();
        $this->getSelectedInscription($value);
    }

    //updatedInscriptionId

    public function getSelectedInscription($id): void
    {
        $this->inscription = Inscription::find($id);
        $this->perceptions = $this->inscription->perceptionsEncours;
    }

    // updatedClasseId

    public function updatedClasseId($value): void
    {
        $this->inscriptions = Inscription::where('annee_id', $this->annee->id)
            ->where('classe_id', $value)
            ->get()
            ->where('perceptions_encours_count', '>', 0);
    }

    public function getSelectedPerception($id): void
    {
        $this->perception = Perception::find($id);
        $this->fee = $this->perception->frais;
        //  dd($this->perception);
    }

    public function clearSelection(): void
    {
        $this->inscription = null;
        $this->perceptions = [];
        $this->perception = null;
        $this->fee = null;
    }

    public function clearSearch(): void
    {
        $this->searchTerm = '';
        $this->inscription = null;
        $this->perceptions = [];
        $this->inscriptions = [];
        $this->perception = null;
        $this->fee = null;
    }

    public function searchInscription(): void
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

    public function payFacture(): void
    {
        $this->validate();
        $done = $this->perception->save();

        if ($done) {
           // $this->onModalClosed('paiement-facture');
            $this->alert('success', "Facture payée avec succès !");
            $this->printIt();
        } else {
            $this->alert('warning', "Echec de paiement de facture !");
        }
    }


    // paiement et impression facture

    private function printIt(): void
    {

        $this->dispatchBrowserEvent('printIt', ['elementId' => "factPrint", 'type' => 'html', 'maxWidth' => 301]);
    }

}
