<?php

namespace App\Http\Livewire\Scolarite\Devoir;

use App\Models\Cours;
use App\Models\Devoir;
use App\Traits\CanDeleteModel;
use App\View\Components\AdminLayout;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DevoirIndexComponent extends Component
{
    use LivewireAlert, CanDeleteModel;

    public Collection $devoirs;

    public function render()
    {
        $this->loadData();
        return view('livewire.scolarite.devoirs.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de cours']);
    }


    public function loadData(): void
    {
        $this->devoirs = Devoir::latest()->get();
    }

    public function deleteCours(Cours $cours)
    {
        $this->deleteModel($cours, 'Cours supprimé avec succès', 'Ce cours est attaché à un enseignant ou à une classe');
    }
}
