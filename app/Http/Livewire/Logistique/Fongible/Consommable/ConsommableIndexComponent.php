<?php

namespace App\Http\Livewire\Logistique\Fongible\Consommable;

use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Consommable;
use App\Models\Unit;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Faker\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ConsommableIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $consommables = [];
    public $units = [];
    public Consommable $consommable;

    protected $rules = [
        'consommable.unit_id' => 'required',
        'consommable.nom' => 'required',
        'consommable.code' => 'nullable',
        'consommable.description' => 'nullable',
    ];

    public function mount()
    {
        $this->authorize("viewAny", Consommable::class);
        $this->loadData();
        $this->initConsommable();
    }

    public function loadData()
    {
        $this->units = Unit::orderBy('nom', 'ASC')->get();
        $this->consommables = Consommable::where('annee_id', Annee::id())->orderBy('nom', 'ASC')->get();
    }

    public function initConsommable()
    {
        $this->consommable = new Consommable();
        if ($this->units->count() > 0) $this->consommable->unit_id = $this->units[0]->id;

    }


    public function render()
    {
        $this->loadData();
        return view('livewire.logistiques.fongibles.consommables.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Consommables']);
    }

    public function addConsommable()
    {
        // Todo: generate proper code
        $this->consommable->code = Factory::create()->unique()->creditCardNumber;
        $this->consommable->annee_id = Annee::id();

        $this->validate();

        $done = $this->consommable->save();
        if ($done) {
            $this->onModalClosed('add-consommable-modal');
            $this->loadData();
            $this->initConsommable();
            $this->alert('success', "Consommable ajouté avec succès !");
        } else {
            $this->alert('warning', "Échec d'ajout de consommable !");
        }
    }

    public function onModalClosed($p_id)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $p_id]);

    }

    public function getSelectedConsommable(Consommable $consommable)
    {
        $this->consommable = $consommable;
        //  dd($this->materiel);
    }

    public function updateConsommable()
    {
        $this->validate();

        $done = $this->consommable->save();
        if ($done) {
            $this->onModalClosed('update-consommable-modal');
            $this->alert('success', "Consommable modifié avec succès !");
        } else {
            $this->alert('warning', "Échec de modification de consommable !");
        }

    }

    public function deleteConsommable()
    {

        try {
            if ($this->consommable->delete()) {
                $this->loadData();
                $this->alert('success', "Consommable supprimé avec succès !");
            } else {
                $this->alert('warning', "Échec de suppression de consommable !");
            }
        } catch (Exception $e) {
            $this->alert('error', "Consommable n'a pas été supprimé, il y a des éléments attachés !");
        }

        $this->onModalClosed('delete-consommable-modal');

    }
}
