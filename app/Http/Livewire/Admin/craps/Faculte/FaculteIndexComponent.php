<?php

namespace App\Http\Livewire\Admin\craps\Faculte;

use App\Models\Option;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FaculteIndexComponent extends Component
{
    use LivewireAlert;

    public $facultes = [];

    public function render()
    {
        $this->loadData();
        return view('livewire.admin.faculte-academique.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Facultés']);
    }

    public function loadData()
    {
        $this->facultes = Option::/* orderBy('encours', 'DESC')-> */ orderBy('nom', 'ASC')->get();
    }

    public function deleteFaculte($id)
    {
        $fa = Option::find($id);
        if (count($fa->filieres) == 0) {
            if ($fa->delete()) {
                $this->loadData();
                $this->alert('success', "Faculté supprimée avec succès !");
            }
        } else {
            $this->alert('warning', "Faculté n'a pas été supprimée, il y a des filières attachées !");
        }
    }
}
