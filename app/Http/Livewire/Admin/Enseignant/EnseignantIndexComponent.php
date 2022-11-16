<?php

namespace App\Http\Livewire\Admin\Enseignant;

use App\Models\Cours;
use App\View\Components\AdminLayout;
use Illuminate\Database\QueryException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EnseignantIndexComponent extends Component
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
        $this->cours = Cours::latest()->get();
    }

    public function deleteCours(Cours $cours)
    {
        try {
            $cours->delete();
            $this->alert('success', 'Cours supprimé avec succès');
        } catch (QueryException) {
            $this->alert('error', 'Ce cours est attaché à un enseignant ou à une classe');
        }
    }
}
