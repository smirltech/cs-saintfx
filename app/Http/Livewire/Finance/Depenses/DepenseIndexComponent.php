<?php

namespace App\Http\Livewire\Finance\Depenses;

use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Depense;
use App\Models\DepenseType;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DepenseIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $annee_id;
    public $depenses = [];
    public $depense;

    public $types = [];
    public $type;

    public $montant;
    public $note;
    public $reference;
    protected $rules = [
        'type.id' => 'required',
    ];

    protected $messages = [
        'montant.required' => 'Le montant est obligatoire !',
        'nom.required' => 'Le nom est obligatoire !',
        'type.id.required' => 'La type est obligatoire !',
    ];

    protected $listeners = ['onModalClosed'];

    public function mount()
    {
        $this->authorize('viewAny', Depense::class);
        $this->annee_id = Annee::id();
        $this->types = DepenseType::orderBy('nom')->get();
        $this->type = $this->types[0] ?? new DepenseType();
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.finance.depenses.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Dépenses']);
    }

    public function loadData()
    {
        $this->types = DepenseType::orderBy('nom')->get();
        $this->depenses = Depense::where('annee_id', $this->annee_id)->orderBy('created_at', 'DESC')->get();
    }

    public function addDepense()
    {
        // dd($this->nom);

        $this->validate([
            'type.id' => 'required',
            'montant' => 'required',
            'note' => 'nullable',
            'reference' => 'nullable',
            'annee_id' => 'required',
        ]);

        Depense::create([
            'depense_type_id' => $this->type->id,
            'montant' => $this->montant,
            'note' => $this->note,
            'reference' => $this->reference,
            'user_id' => Auth::user()->id,
            'annee_id' => $this->annee_id,
        ]);

        $this->alert('success', "Dépense ajoutée avec succès !");

        // close the modal by specifying the id of the modal
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-depense-modal']);
        $this->onModalClosed();
    }


    public function getSelectedDepense($depense_id)
    {
        //dd($depense_id);
        $this->depense = Depense::find($depense_id);
        $this->type = $this->depense->type;
        $this->montant = $this->depense->montant;
        $this->note = $this->depense->note;
        $this->reference = $this->depense->reference;
    }

    public function updateDepense()
    {
        $this->validate([
            'type.id' => 'required',
            'montant' => 'required',
            'note' => 'required',
            'reference' => 'nullable',
        ]);

        $done = $this->depense->update([
            'depense_type_id' => $this->type->id,
            'montant' => $this->montant,
            'note' => $this->note,
            'reference' => $this->reference,
            'user_id' => Auth::user()->id,
        ]);
        if ($done) {
            $this->alert('success', "Depense modifiée avec succès !");

            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-depense-modal']);
        } else {
            $this->alert('warning', "Echec de modification de dépense !");
        }
        $this->onModalClosed();

    }

    public function deleteDepense()
    {

        if ($this->depense->delete()) {
            $this->loadData();
            $this->alert('success', "Dépense supprimée avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-depense-modal']);
        }

        $this->onModalClosed();

    }

}
