<?php

namespace App\Http\Livewire\Admin\craps\Faculte;

use App\Models\Option;
use App\View\Components\AdminLayout;
use Livewire\Component;

class FaculteShowComponent extends Component
{
    public $faculte;


    public function mount(Option $faculte)
    {
        $this->faculte = $faculte;
    }

    public function render()
    {
        return view('livewire.admin.faculte-academique.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur la faculté']);
    }
}
