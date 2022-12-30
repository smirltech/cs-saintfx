<?php

namespace App\Http\Livewire\Logistiques\Materiel;

use App\Models\Materiel;
use App\Models\MaterielCategory;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MaterielShowComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;

    public Materiel $materiel;
    public $categories = [];

    protected $rules = [
        'materiel.materiel_category_id' => 'required',
        'materiel.nom' => 'required',
        'materiel.description' => 'nullable',
        'materiel.montant' => 'required',
        'materiel.date' => 'nullable',
        'materiel.vie' => 'required',
        'materiel.status' => 'nullable',
    ];

    public function mount(Materiel $materiel)
    {
        $this->loadData();
        $this->materiel = $materiel;
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.logistiques.materiels.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur le matériel']);
    }

    public function loadData()
    {
        $this->categories = MaterielCategory::orderBy('nom', 'ASC')->get();
        //  dd($this->categories);
    }

    public function onModalClosed($p_id)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $p_id]);

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
        $this->materiel->refresh();
    }
}
