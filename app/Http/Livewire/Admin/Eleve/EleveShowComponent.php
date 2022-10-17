<?php

namespace App\Http\Livewire\Admin\Eleve;

use App\Models\Eleve;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EleveShowComponent extends Component
{
    use LivewireAlert;
    public $eleve;

    public function mount(Eleve $eleve)
    {
        $this->eleve = $eleve;
    }

    public function render()
    {
        return view('livewire.admin.eleves.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur l\'élève']);
    }

}
