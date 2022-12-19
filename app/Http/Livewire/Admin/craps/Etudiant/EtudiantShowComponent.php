<?php

namespace App\Http\Livewire\Admin\craps\Etudiant;

use App\Models\Annee;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\View\Components\AdminLayout;
use Livewire\Component;

class EtudiantShowComponent extends Component
{
    public $annee_courante;
    public $etudiant;
    public $admission;


    public function mount(Etudiant $etudiant)
    {
        $this->annee_courante = Annee::where('encours', true)->first();
        $this->etudiant = $etudiant;
        $this->admission = Inscription::where(["etudiant_id" => $etudiant->id])->orderBy('created_at', 'DESC')->first();
    }


    public function render()
    {
        return view('livewire.admin.etudiant-academique.show')
            ->layout(AdminLayout::class, ['title' => "Profile"]);
    }
}
