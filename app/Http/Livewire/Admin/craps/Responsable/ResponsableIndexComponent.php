<?php

namespace App\Http\Livewire\Admin\craps\Responsable;

use App\Models\Annee;
use App\Models\Inscription;
use App\Models\Responsable;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ResponsableIndexComponent extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $responsables = [];
    public $responsable_nom;
    public $responsable_sexe;
    public $responsable_telephone;
    public $responsable_email;
    public $responsable_adresse;

    protected $listeners = ['onModalClosed'];

    public function mount(){
        #TODO: move this to mount()
        $this->responsables = $this->loadData();

    }

    public function render()
    {
        $this->responsables = $this->loadData();

        return view('livewire.admin.responsables.index')
            ->layout(AdminLayout::class, ['title' => "Liste de responsables"]);
    }

    public function onModalClosed()
    {
        $this->reset(['responsable_nom', 'responsable_sexe', 'responsable_telephone', 'responsable_email', 'responsable_adresse']);
    }

    public function loadData()
    {
       return Responsable::orderBy('nom', 'ASC')->get();

    }

    public function addThisResponsable()
    {

        $this->validate([
            'responsable_nom' => 'required|string',
            'responsable_sexe' => 'nullable',
            'responsable_telephone' => 'nullable|string',
            'responsable_email' => 'nullable',
            'responsable_adresse' => 'nullable',
        ]);

            Responsable::create([
                'nom' => $this->responsable_nom,
                'sexe' => $this->responsable_sexe,
                'telephone' => $this->responsable_telephone,
                'email' => $this->responsable_email,
                'adresse' => $this->responsable_adresse,
            ]);

            // close the modal by specifying the id of the modal
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-responsable-modal']);
            $this->onModalClosed();


    }


    public function deleteResponsable($responsable_id)
    {
        $responsable = Responsable::find($responsable_id);
        dd($responsable);
        if (count($responsable->responsable_eleves) == 0) {
            if ($responsable->delete()) {
                $this->loadData();
                $this->alert('success', "Responsable supprimé avec succès !");
               // $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-section-modal']);
            }
        } else {
            $this->alert('warning', "Responsable n'a pas été supprimé, il y a des élèves attachés !");
        }

    }

}
