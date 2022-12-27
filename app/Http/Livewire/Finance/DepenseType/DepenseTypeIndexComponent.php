<?php

namespace App\Http\Livewire\Finance\DepenseType;

use App\Models\DepenseType;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DepenseTypeIndexComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;

    public $depenseTypes = [];
    public $depenseType;
    protected $messages = [
        'depenseType.nom.required' => 'Ce nom est obligatoire !',
    ];

    public function mount()
    {
        $this->depenseType = new DepenseType();
    }


    public function loadData()
    {
        $this->depenseTypes = DepenseType::orderBy('nom')->get();
    }


    public function render()
    {
        $this->loadData();
        return view('livewire.finance.depenses_types.index')
            ->layout(AdminLayout::class);
    }

    public function addDepense()
    {
        // dd($this->nom);

        $this->validate([
            'nom' => 'required|unique:depenses_types',
            'description' => 'nullable',
        ]);

        $this->depenseType->create();

        $this->alert('success', "Dépense Type ajoutée avec succès !");
        $this->onModalClosed('add-option-modal');
    }

    public function onModalClosed($modal_id)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $modal_id]);
    }

    public function getSelectedDepenseType(DepenseType $depenseType)
    {
        $this->depenseType = $depenseType;
    }

    public function updateDepenseType()
    {
        $this->validate([
            'nom' => [
                "required",
                Rule::unique((new DepenseType())->getTable(), "nom")->ignore($this->depenseType->id)

            ],

            'description' => 'nullable',
        ]);

        $done = $this->depenseType->update();
        if ($done) {
            $this->alert('success', "Dépense Type modifiée avec succès !");
        } else {
            $this->alert('warning', "Echec de modification de Dépense Type !");
        }
        $this->onModalClosed('edit-option-modal');

    }

    public function deleteDepense()
    {
        if (count($this->depenseType->depenses) == 0) {
            if ($this->depenseType->delete()) {
                $this->loadData();
                $this->alert('success', "Dépense Type supprimée avec succès !");
            }
        } else {
            $this->alert('warning', "Dépense Type n'a pas été supprimée, il y a des Dépenses attachées !");
        }
        $this->onModalClosed('delete-option-modal');

    }


    /* public function deleteOption($id)
     {
         $option = Option::find($id);
         if (count($option->filieres) == 0) {
             if ($option->delete()) {
                 $this->loadData();
                 $this->alert('success', "Option supprimée avec succès !");
             }
         } else {
             $this->alert('warning', "Section n'a pas été supprimée, il y a des filières attachées !");
         }
     }*/
}
