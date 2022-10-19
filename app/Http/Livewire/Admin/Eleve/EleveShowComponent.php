<?php

namespace App\Http\Livewire\Admin\Eleve;

use App\Helpers\Helpers;
use App\Models\Annee;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Traits\FakeProfileImage;
use App\View\Components\AdminLayout;
use Illuminate\Support\Facades\Http;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EleveShowComponent extends Component
{
    use LivewireAlert;
    use FakeProfileImage;

    public $eleve;
    public $inscription;
    public $annee_courante;
    public $profile_url;

    public $responsable_relation;

    protected $listeners = [ 'onModalClosed'];

    public function onModalClosed()
    {
       // $this->clearValidation();
       // $this->reset(['nom', 'code']);
    }

    public function mount(Eleve $eleve)
    {
        $this->annee_courante = Annee::where('encours', true)->first();
        $this->inscription = Inscription::where(['eleve_id'=>$this->eleve->id,'annee_id'=>$this->annee_courante->id])->first();
        $this->eleve = $eleve;
        $this->responsable_relation = $this->eleve->responsable_eleve->relation;
       // $this->profile_url =Helpers::fakePicsum($this->eleve->id, 120, 120);
      //  dd($this->profile_url);

        $this->setFakeProfileImageUrl();
    }

    public function reloadData(){
        $this->eleve = Eleve::find($this->eleve->id);
        $this->inscription = Inscription::where(['eleve_id'=>$this->eleve->id,'annee_id'=>$this->annee_courante->id])->first();
        $this->responsable_relation = $this->eleve->responsable_eleve->relation;

        $this->setFakeProfileImageUrl();
    }

    public function render()
    {
        return view('livewire.admin.eleves.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur l\'élève']);
    }

    public function editRelation(){

        $done =$this->eleve->responsable_eleve->update([
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
