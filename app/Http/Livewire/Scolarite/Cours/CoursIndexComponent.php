<?php

namespace App\Http\Livewire\Scolarite\Cours;

use App\Models\Cours;
use App\Traits\CanDeleteModel;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CoursIndexComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert, CanDeleteModel;

    public $cours = [];

    public function render()
    {
        $this->loadData();
        return view('livewire.scolarite.cours.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de cours']);
    }


    public function loadData()
    {
        $this->cours = Cours::latest()->get();
    }

    public function deleteCours(Cours $cours)
    {
        $this->deleteModel($cours, 'Cours supprimé avec succès', 'Ce cours est attaché à un enseignant ou à une classe');
    }
}
