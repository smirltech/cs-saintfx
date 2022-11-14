<?php

namespace App\Http\Livewire\Admin\Cours;

use App\Models\Classe;
use App\Models\Cours;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CoursIndexComponent extends Component
{
    use LivewireAlert;

    public $cours = [];

    public function render()
    {
        $this->loadData();
        return view('livewire.admin.cours.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de cours']);
    }


    public function loadData()
    {
        $this->cours = Cours::orderBy('code')->get();
    }

    public function deleteClasse($id)
    {

        $fa = Classe::find($id);
        if ($fa->delete()) {
            $this->loadData();
            $this->alert('success', 'Classe supprimée avec succès');

        }
    }
}
