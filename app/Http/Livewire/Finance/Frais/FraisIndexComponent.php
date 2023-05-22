<?php

namespace App\Http\Livewire\Finance\Frais;


use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Frais;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FraisIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $sections = [];
    public $options = [];
    public $filieres = [];
    public $classes = [];

    public $section_id;
    public $option_id;
    public $filiere_id;
    public $classe_id;


    public $frais = [];
    public $fee; // fee c'est le français de frais.
    // Étant donné que frais s'écrit de la même façon au singulier et au pluriel, j'utilise frais pour le pluriel et fee pour le singulier

    public $nom;
    public $description;
    public $montant;
    public $annee_id;
    public $classable_id;
    public $classable_type;

    protected $messages = [
        'montant.required' => 'Le montant est obligatoire !',
        'nom.required' => 'Le nom est obligatoire !',
        'annee_id.required' => 'L\'année est obligatoire !',
    ];

    //protected $listeners = ['onModalClosed'];

    public function mount(): void
    {
        $this->authorize('viewAny', Frais::class);
        $this->annee_id = Annee::id();
        $this->frais = Frais::where(['annee_id' => $this->annee_id])->orderBy('nom')->get();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.finance.frais.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Frais']);
    }

    public function addFrais(): void
    {

        $this->validate([
            'nom' => 'required',
            'montant' => 'required',
            'classable_id' => 'required',
            'classable_type' => 'required',
        ]);

        Frais::create([
            'nom' => $this->nom,
            'description' => $this->description,
            'montant' => $this->montant,
            'annee_id' => $this->annee_id,
        ]);
        $this->onModalClosed('add-frais-modal');
        $this->alert('success', "Frais ajouté avec succès !");
        // $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-frais-modal']);
    }

    public function getSelectedFrais(Frais $fee)
    {
        $this->fee = $fee;
        $this->nom = $fee->nom;
        $this->description = $fee->description;
        $this->montant = $fee->montant;
    }

    public function updateFrais(): void
    {
        $this->validate([
            'nom' => 'required',
            'montant' => 'required',
            'classable_id' => 'required',
            'classable_type' => 'required',
        ]);

        $done = $this->fee->update([
            'nom' => $this->nom,
            'description' => $this->description,
            'montant' => $this->montant,
        ]);
        if ($done) {
            $this->onModalClosed('edit-frais-modal');
            $this->alert('success', "Frais modifié avec succès !");
        } else {
            $this->alert('warning', "Echec de modification de frais !");
        }


    }


    // =================================================

    public function deleteFrais(): void
    {

        if (count($this->fee->perceptions) == 0) {
            if ($this->fee->delete()) {
                $this->onModalClosed('delete-frais-modal');
                $this->alert('success', "Frais supprimé avec succès !");
            }
        } else {
            $this->alert('warning', "Frais n'a pas été supprimé, il y a des perceptions attachées !");
        }

    }
}
