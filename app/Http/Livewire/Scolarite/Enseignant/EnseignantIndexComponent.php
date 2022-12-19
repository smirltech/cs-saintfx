<?php

namespace App\Http\Livewire\Scolarite\Enseignant;

use App\Models\Enseignant;
use App\Traits\CanDeleteModel;
use App\View\Components\AdminLayout;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EnseignantIndexComponent extends Component
{
    use LivewireAlert;
    use CanDeleteModel;

    public Collection $enseignants;

    public function mount()
    {
        $this->enseignants = Enseignant::latest()->get();
    }

    public function render()
    {
        $data = ['title' => 'Liste d\'enseignants'];
        return view('livewire.admin.enseingnants.index', $data)
            ->layout(AdminLayout::class, $data);
    }


    public function delete(Enseignant $enseignant)
    {
        $this->deleteModel($enseignant, 'Enseignant supprimé avec succès');
    }
}
