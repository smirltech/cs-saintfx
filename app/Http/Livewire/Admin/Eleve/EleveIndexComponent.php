<?php

namespace App\Http\Livewire\Admin\Eleve;

use App\Models\Classe;
use App\Models\Eleve;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EleveIndexComponent extends Component
{
    use LivewireAlert;

    public $eleves = [];

    public function render()
    {
        $this->loadData();
        return view('livewire.admin.eleves.index',[
            'eleves'=>$this->eleves
        ])
            ->layout(AdminLayout::class, ['title' => 'Liste d\'élèves']);
    }


    public function loadData()
    {
        $this->eleves = Eleve::orderBy('nom')->get();
    }

}
