<?php

namespace App\Http\Livewire\Logistique\Unit;

use App\Models\Unit;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UnitIndexComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;

    public $units = [];
    public Unit $unit;

    protected $rules = [
        'unit.nom' => 'required|unique:units, nom',
        'unit.code' => 'required',
    ];

    public function mount()
    {
        $this->initUnit();
        $this->loadData();
    }

    public function initUnit()
    {
        $this->unit = new Unit();
    }

    public function loadData()
    {
        $this->units = Unit::orderBy('nom')->get();
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.logistiques.units.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Units']);
    }


    public function addUnit()
    {
        $this->validate();

        try {
            $done = $this->unit->save();
            if ($done) {
                $this->onModalClosed('add-unit-modal');
                $this->loadData();
                $this->initUnit();
                $this->alert('success', "Unité ajoutée avec succès !");
            } else {
                $this->alert('warning', "Échec d'ajout de unité !");
            }
        } catch (Exception $exception) {
            //  dd($exception);
            $this->alert('error', "Échec de d'ajout d'unité, ce nom existe déjà !");
        }

    }

    public function onModalClosed($p_id)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $p_id]);

    }

    public function getSelectedUnit(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function updateUnit()
    {
        $this->validate([
            'unit.nom' => [
                "required",
                Rule::unique((new Unit())->getTable(), "nom")->ignore($this->unit->id)
            ],
            'unit.code' => 'required',
        ]);

        $done = $this->unit->save();
        if ($done) {
            $this->onModalClosed('update-unit-modal');
            $this->alert('success', "Unité modifiée avec succès !");
        } else {
            $this->alert('warning', "Échec de modification d'unité !");
        }

    }

    public function deleteUnit()
    {
        if ($this->unit->delete()) {
            $this->loadData();
            $this->alert('success', "Unité supprimée avec succès !");
        } else {
            $this->alert('warning', "Unité n'a pas été supprimée, il y a des éléments attachés !");
        }
        $this->onModalClosed('delete-unit-modal');

    }

}
