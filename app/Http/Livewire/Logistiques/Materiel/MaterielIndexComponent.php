<?php

namespace App\Http\Livewire\Logistiques\Materiel;

use App\Models\Materiel;
use App\Models\MaterielCategory;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MaterielIndexComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;

    public $materiels = [];
    public $categories = [];
    public Materiel $materiel;

    protected $rules = [
        'materiel.nom' => 'required',
        'materiel.materiel_category_id' => 'nullable',
        'materiel.description' => 'nullable',
    ];

    public function mount()
    {
        $this->initMateriel();
    }

    public function loadData()
    {
        $this->categories = MaterielCategory::orderBy('nom', 'ASC')->get();
        $this->materiels = Materiel::orderBy('nom', 'ASC')->get();
    }

    public function initMateriel()
    {
        $this->materiel = new Materiel();
    }


    public function render()
    {
        $this->loadData();
        return view('livewire.logistiques.materiels.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Matériels']);
    }

    public function addMateriel()
    {
        $this->validate();

        $done = $this->materiel->save();
        if ($done) {
            $this->onModalClosed('add-materiel-modal');
            $this->loadData();
            $this->initMateriel();
            $this->alert('success', "Matériel ajouté avec succès !");
        } else {
            $this->alert('warning', "Échec d'ajout de matériel !");
        }
    }

    public function onModalClosed($p_id)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $p_id]);

    }

    public function getSelectedMateriel(Materiel $materiel)
    {
        $this->materiel = $materiel;
        // dd($this->category->categories);
    }

    public function updateMateriel()
    {
        $this->validate();

        $done = $this->materiel->save();
        if ($done) {
            $this->onModalClosed('update-materiel-modal');
            $this->alert('success', "Matériel modifié avec succès !");
        } else {
            $this->alert('warning', "Échec de modification de matériel !");
        }

    }

    public function deleteMateriel()
    {

        if ($this->category->delete()) {
            $this->loadData();
            $this->alert('success', "Matériel supprimé avec succès !");
        } else {
            $this->alert('warning', "Matériel n'a pas été supprimé, il y a des éléments attachés !");
        }
        $this->onModalClosed('delete-materiel-modal');

    }
}
