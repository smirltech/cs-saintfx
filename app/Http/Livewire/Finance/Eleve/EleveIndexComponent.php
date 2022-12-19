<?php

namespace App\Http\Livewire\Finance\Eleve;

use App\Enums\FraisFrequence;
use App\Enums\FraisType;
use App\Http\Integrations\Scolarite\Requests\Annee\GetCurrentAnnneRequest;
use App\Http\Integrations\Scolarite\Requests\Inscription\GetInscriptionsRequest;
use App\Models\Frais;
use App\Models\Perception;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EleveIndexComponent extends Component
{
    use LivewireAlert;

    // public $perceptions = [];
    public $perception;

    public $nom;
    public $description;
    public $montant;
    public $annee_id;
    public $frequence = FraisFrequence::mensuel;
    public $type = FraisType::frais_divers;

    protected $messages = [
        'montant.required' => 'Le montant est obligatoire !',
        'nom.required' => 'Le nom est obligatoire !',
        'annee_id.required' => 'L\'année est obligatoire !',
    ];

    protected $listeners = ['onModalClosed'];

    public function mount()
    {
        //Annee::class
        $this->annee_id = (new GetCurrentAnnneRequest())->send()->dto()->id;

    }

    public function render()
    {
        // $this->loadData();
        $request = new GetInscriptionsRequest(anneeId: $this->annee_id);
        //$request->disableCaching();
        $inscriptions = $request->send()->dto();

        //dd($inscriptions);
        return view('livewire.admin.eleves.index', ['inscriptions' => $inscriptions])
            ->layout(AdminLayout::class, ['title' => 'Liste de Perceptions']);
    }

    public function addFrais()
    {
        // dd($this->nom);

        $this->validate([
            'nom' => 'required',
            'montant' => 'required',
        ]);

        Frais::create([
            'nom' => $this->nom,
            'description' => $this->description,
            'montant' => $this->montant,
            'annee_id' => $this->annee_id,
            'frequence' => $this->frequence,
            'type' => $this->type,
        ]);

        $this->alert('success', "Frais ajouté avec succès !");

        // close the modal by specifying the id of the modal
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-frais-modal']);
        $this->onModalClosed();
    }

    public function onModalClosed()
    {
        $this->clearValidation();
        $this->reset(['nom', 'description', 'montant']);
    }

    public function getSelectedFrais(Frais $fee)
    {
        $this->fee = $fee;
        $this->nom = $fee->nom;
        $this->description = $fee->description;
        $this->montant = $fee->montant;
        $this->frequence = $fee->frequence->value;
        $this->type = $fee->type->value;
    }

    public function updateFrais()
    {
        $this->validate([
            'nom' => 'required',
            'montant' => 'required',
        ]);

        $done = $this->fee->update([
            'nom' => $this->nom,
            'description' => $this->description,
            'montant' => $this->montant,
            'frequence' => $this->frequence,
            'type' => $this->type,
        ]);
        if ($done) {
            $this->alert('success', "Frais modifié avec succès !");

            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-frais-modal']);
        } else {
            $this->alert('warning', "Echec de modification de frais !");
        }
        $this->onModalClosed();

    }

    public function deleteFrais()
    {

        if (count($this->fee->perceptions) == 0) {
            if ($this->fee->delete()) {
                $this->loadData();
                $this->alert('success', "Frais supprimé avec succès !");
                $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-frais-modal']);
            }
        } else {
            $this->alert('warning', "Frais n'a pas été supprimé, il y a des perceptions attachées !");
        }
        $this->onModalClosed();

    }

    public function loadData()
    {
        //Todo: we will need to specify the année scolaire;
        $this->perceptions = Perception::orderBy('created_at', 'DESC')->get();
    }

}
