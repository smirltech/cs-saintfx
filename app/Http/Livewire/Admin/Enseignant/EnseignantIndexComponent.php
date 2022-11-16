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

    public function mount()
    {
        $this->cours = Cours::latest()->get();
    }

    public function render()
    {
        $data = ['title' => 'Liste d\'enseignants'];
        return view('livewire.admin.enseingnants.index', $data)
            ->layout(AdminLayout::class, $data);
    }


    public function deleteCours(Cours $cours)
    {
        $this->deleteModel($cours, 'Cours supprimé avec succès', 'Erreur lors de la suppression');
    }
}
