<?php

namespace App\Http\Livewire\Admin\Filiere;

use App\Models\Filiere;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FiliereIndexComponent extends Component
{
    use LivewireAlert;

    public $filieres = [];

    public function render()
    {
        $this->loadData();
        return view('livewire.admin.filieres.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Filières']);
    }


    public function loadData()
    {
        $this->filieres = Filiere::/* orderBy('encours', 'DESC')-> */ orderBy('nom', 'ASC')->get();
    }

    public function deleteFiliere($id)
    {

        $fa = Filiere::find($id);
      //  if (count($fa->promotions) == 0) {
            if ($fa->delete()) {
                $this->loadData();
                $this->alert('success', "Filière supprimée avec succès !");
            }
//        } else {
//            $this->alert('warning', "Filière n'a pas été supprimée, il y a des promotions attachées !");
//        }
    }
}
