<?php

namespace App\Http\Livewire\Admin\Enseignant;

use App\Models\Cours;
use App\Traits\HasDeleteModel;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EnseignantIndexComponent extends Component
{
    use LivewireAlert;
    use HasDeleteModel;

    public $cours = [];

    public function render()
    {
        $this->loadData();
        return view('livewire.admin.enseingnants.index')
            ->layout(AdminLayout::class, ['title' => 'Liste d\'enseignants']);
    }


    public function loadData()
    {
        $this->cours = Cours::latest()->get();
    }

    public function deleteCours(Cours $cours)
    {
        $this->deleteModel($cours, 'Cours supprimé avec succès', 'Erreur lors de la suppression');
    }
}
