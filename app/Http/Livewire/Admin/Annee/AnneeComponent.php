<?php

namespace App\Http\Livewire\Admin\Annee;

use App\Models\Annee;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AnneeComponent extends Component
{
    use LivewireAlert;

    public $annees;
    public $annee_id = -1;
    public $nom = "";
    public $iconB = "fa fa-plus";
    public bool $isAdding = false;


    protected $rules = [
        'nom' => 'required',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->annees = Annee::/* orderBy('encours', 'DESC')-> */ orderBy('nom', 'DESC')->get();
    }

    public function render()
    {
        return view('livewire.admin.annees.index')
            ->layout(AdminLayout::class, ['title' => "Liste d'années scolaires"]);
    }

    public function toggleIsAdding()
    {
        $this->isAdding = !$this->isAdding;
        if ($this->isAdding) {
            $iconB = "fa fa-plus";
        } else {
            $iconB = "fa fa-minus";
        }
        $this->annee_id = -1;
    }

    public function addAnnee()
    {
        $validatedData = $this->validate([
            'nom' => 'required',
        ]);
//dd($validatedData);
        Annee::create(['nom' => $validatedData['nom']]);

        $this->loadData();
        $this->isAdding = false;
        $this->nom = '';

        $this->alert('success', 'Année ajoutée avec succès');
    }

    public function deleteAnnee($id)
    {
        $aa = Annee::find($id);
        if ($aa->delete()) {
            $this->loadData();
            $this->resetAnneeId();
            $this->alert('success', 'Année supprimée avec succès');
        }
    }

    public function resetAnneeId()
    {
        $this->annee_id = -1;
        $this->isAdding = false;
    }

    public function setAnneeEnCours($id)
    {
        $aa = Annee::find($id);
        //if ($aa != null) {
        Annee::query()->where('encours', true)->update(['encours' => false]);
        $aa->encours = true;
        $aa->save();
        $this->loadData();
        $this->resetAnneeId();
        $this->alert('success', 'Année en cours modifiée avec succès');
        // }

    }

    public function editAnnee($id)
    {
        $this->annee_id = $id;
        $aa = Annee::find($id);
        $this->nom = $aa->nom_edit;
        $this->loadData();
    }

    public function updateAnnee()
    {
        $validatedData = $this->validate([
            'nom' => 'required',
        ]);

        $aa = Annee::find($this->annee_id);
        $aa->nom = $this->nom;
        $aa->save();

        $this->loadData();
        $this->resetAnneeId();
        $this->nom = '';

        $this->alert('success', 'Année modifiée avec succès');
    }
}
