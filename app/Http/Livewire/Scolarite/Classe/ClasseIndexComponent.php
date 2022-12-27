<?php

namespace App\Http\Livewire\Scolarite\Classe;

use App\Models\Classe;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ClasseIndexComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;

    public $classes = [];

    public function render()
    {
        $this->loadData();
        return view('livewire.scolarite.classes.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Classes']);
    }


    public function loadData()
    {
        $this->classes = Classe::orderBy('code')->get();
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
