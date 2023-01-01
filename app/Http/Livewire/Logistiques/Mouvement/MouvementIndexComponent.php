<?php

namespace App\Http\Livewire\Logistiques\Mouvement;

use App\Enums\MaterialStatus;
use App\Models\Materiel;
use App\Models\MaterielCategory;
use App\Models\Mouvement;
use App\Models\User;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MouvementIndexComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;

    public $mouvements = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->mouvements = Mouvement::orderBy('date', 'DESC')->get();
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.logistiques.mouvements.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Mouvements']);
    }

}
