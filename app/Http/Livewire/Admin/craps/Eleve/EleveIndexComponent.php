<?php

namespace App\Http\Livewire\Admin\craps\Eleve;

use App\Models\Classe;
use App\Models\Eleve;
use App\Traits\FakeProfileImage;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EleveIndexComponent extends Component
{
    use LivewireAlert;
    use FakeProfileImage;

    public $eleves = [];

    public function mount()
    {
        $this->loadData();
    }

    public function render()
    {

        return view('livewire.admin.eleves.index',[
            'eleves'=>$this->eleves
        ])
            ->layout(AdminLayout::class, ['title' => 'Liste d\'élèves']);
    }


    public function loadData()
    {
        $this->eleves = Eleve::orderBy('nom')->get();
        $this->setFakeProfileImageUrl();
    }

}
