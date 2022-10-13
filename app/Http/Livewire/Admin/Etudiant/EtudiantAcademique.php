<?php

namespace App\Http\Livewire\Admin\Etudiant;

use App\Models\Etudiant;
use Livewire\Component;

class EtudiantAcademique extends Component
{

    public $etudiants = [];

    public function render()
    {
        $this->loadData();
        return view('livewire.etudiant-academique.etudiant-academique');
    }


    public function loadData()
    {
        $this->etudiants = Etudiant::/* orderBy('encours', 'DESC')-> */ orderBy('nom', 'ASC')->get();
    }

    public function deleteEtudiant($id)
    {

        $fa = Etudiant::find($id);
        if ($fa->delete()) {
            $this->loadData();
        }
    }
}
