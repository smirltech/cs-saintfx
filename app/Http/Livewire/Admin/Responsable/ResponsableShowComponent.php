<?php

namespace App\Http\Livewire\Admin\Responsable;

use App\Models\Option;
use App\Models\Responsable;
use App\Models\Section;
use App\Traits\SectionCode;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ResponsableShowComponent extends Component
{
    use LivewireAlert;
    public $responsable;
    public $nom;
    public $sexe;
    public $telephone;
    public $email;
    public $adresse;

    protected $rules = [
        'nom' => 'required|string',
        'sexe' => 'nullable',
        'telephone' => 'nullable|string',
        'email' => 'nullable',
        'adresse' => 'nullable',
    ];

    protected $listeners = ['onModalClosed'];


    public function mount(Responsable $responsable)
    {
        $this->responsable = $responsable;

    }

    public function onModalClosed()
    {
        $this->reset(['nom', 'sexe', 'telephone', 'email', 'adresse']);
    }

    public function render()
    {
        return view('livewire.admin.responsables.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur le responsable']);
    }

    public function fillDataToModal(){
        $this->nom = $this->responsable->nom;
        $this->sexe = $this->responsable->sexe;
        $this->telephone = $this->responsable->telephone;
        $this->email = $this->responsable->email;
        $this->adresse = $this->responsable->adresse;
    }

    public function submitResponsable()
    {
        if (isset($this->nom)) {
            $this->responsable->update([
                'nom'=>$this->nom,
                'sexe'=>$this->sexe,
                'telephone'=>$this->telephone,
                'email'=>$this->email,
                'adresse'=>$this->adresse,
            ]);


            // close the modal by specifying the id of the modal
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-responsable-modal']);
            $this->onModalClosed();
        }

    }

}
