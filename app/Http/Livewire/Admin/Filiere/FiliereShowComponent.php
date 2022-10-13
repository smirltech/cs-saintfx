<?php

namespace App\Http\Livewire\Admin\Filiere;

use App\Models\Filiere;
use App\View\Components\AdminLayout;
use Livewire\Component;

class FiliereShowComponent extends Component
{
    public $filiere;


    public function mount(Filiere $filiere)
    {
        $this->filiere = $filiere;
    }


    public function render()
    {
        return view('livewire.admin.filiere-academique.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur la filière']);
    }
}
