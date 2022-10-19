<?php

namespace App\Http\Livewire\Admin\Responsable;

use App\Models\Option;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
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

    public $responsable_eleve;
    public $responsable_relation;

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

    public function reloadData(){
        $this->responsable = Responsable::find($this->responsable->id);
    }

    public function onModalClosed()
    {
        $this->reset(['nom', 'sexe', 'telephone', 'email', 'adresse', 'responsable_eleve', 'responsable_relation']);
    }

    public function render()
    {
        $this->reloadData();
        return view('livewire.admin.responsables.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur le responsable']);
    }

    public function selectResponsableEleve($relationEleve_id){
     //   dd($relationEleve);
        $this->responsable_eleve = ResponsableEleve::find($relationEleve_id);
        $this->responsable_relation = $this->responsable_eleve->relation;
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

    public function deleteResponsable()
    {
        if (count($this->responsable->responsable_eleves) == 0) {
            if ($this->responsable->delete()) {
                //$this->loadData();
               // $this->alert('success', "Responsable supprimé avec succès !");
                // $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-responsable-modal']);
                $this->flash('success', 'Responsable supprimé avec succès', [], route('admin.responsables'));

            }
        } else {

            $this->alert('warning', "Responsable n'a pas été supprimé, il y a des élèves attachés !");
             $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-responsable-modal']);
            $this->onModalClosed();
        }

    }

    public function editRelation(){

        $done =$this->responsable_eleve->update([
            'relation' => $this->responsable_relation,
        ]);

        if ($done) {
            $this->reloadData();
            $this->alert('success', "Relation modifiée avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-relation-modal']);
        } else {
            $this->alert('warning', "Echec de modification de relation !");
        }
        $this->onModalClosed();

    }



}
