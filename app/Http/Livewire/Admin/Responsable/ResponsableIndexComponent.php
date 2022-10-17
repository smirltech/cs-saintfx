<?php

namespace App\Http\Livewire\Admin\Responsable;

use App\Models\Annee;
use App\Models\Inscription;
use App\Models\Responsable;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ResponsableIndexComponent extends Component
{
    use LivewireAlert;
    use WithPagination;

    public function render()
    {

        #TODO: move this to mount()
        $responsables = $this->loadData();


        return view('livewire.admin.responsables.index', [
            'responsables' => $responsables->get(),
        ])
            ->layout(AdminLayout::class, ['title' => "Liste de responsables"]);
    }

    public function loadData()
    {
        $query = Responsable::query();
        $query->orderBy('nom', 'ASC');
        return $query;
    }

}
