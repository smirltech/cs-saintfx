<?php

namespace App\Http\Livewire\Finance\Depense;

use App\Enums\DepenseCategorie;
use App\Http\Integrations\Scolarite\Requests\Annee\GetCurrentAnnneRequest;
use App\Models\Depense;
use App\View\Components\AdminLayout;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DepenseIndexComponent extends Component
{
    use LivewireAlert;

    public $annee_id;
    public $depenses = [];
    public $depense;

    public $categorie = DepenseCategorie::autre;
    public $montant;
    public $note;
    public $reference;

    protected $messages = [
        'montant.required' => 'Le montant est obligatoire !',
        'nom.required' => 'Le nom est obligatoire !',
        'categorie.required' => 'La categorie est obligatoire !',
    ];

    protected $listeners = ['onModalClosed'];

    public function mount()
    {
        $this->annee_id = (new GetCurrentAnnneRequest())->send()->dto()->id;
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.finance.depenses.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Dépenses']);
    }

    public function loadData()
    {
        // todo: we should consider annee_id when fetching data
        $this->depenses = Depense::where('annee_id', $this->annee_id)->orderBy('created_at', 'DESC')->get();
    }

    public function addDepense()
    {
        // dd($this->nom);

        $this->validate([
            'categorie' => 'required',
            'montant' => 'required',
            'note' => 'nullable',
            'reference' => 'nullable',
            'annee_id' => 'required',
        ]);

        Depense::create([
            'categorie' => $this->categorie,
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

    public function onModalClosed()
    {
        $this->clearValidation();
        $this->reset(['categorie', 'montant', 'note', 'reference']);
    }

    public function getSelectedDepense(Depense $depense)
    {
        $this->depense = $depense;
        $this->categorie = $depense->categorie;
        $this->montant = $depense->montant;
        $this->note = $depense->note;
        $this->reference = $depense->reference;
    }

    public function updateDepense()
    {
        $this->validate([
            'categorie' => 'required',
            'montant' => 'required',
            'note' => 'required',
            'reference' => 'nullable',
        ]);

        $done = $this->depense->update([
            'categorie' => $this->categorie,
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
