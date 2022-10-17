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

    public function mount(Eleve $eleve)
    {
        $this->annee_courante = Annee::where('encours', true)->first();
        $this->inscription = Inscription::where(['eleve_id'=>$this->eleve->id,'annee_id'=>$this->annee_courante->id])->first();
        $this->eleve = $eleve;
       // $this->profile_url =Helpers::fakePicsum($this->eleve->id, 120, 120);
      //  dd($this->profile_url);

        $this->setFakeProfileImageUrl();
    }

    public function render()
    {
        return view('livewire.admin.eleves.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur l\'élève']);
    }

}
