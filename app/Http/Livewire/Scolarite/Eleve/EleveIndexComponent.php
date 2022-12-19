<?php

namespace App\Http\Livewire\Scolarite\Eleve;

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

    public function loadData()
    {
        $this->eleves = Eleve::orderBy('nom')->get();
        $this->setFakeProfileImageUrl();
    }

    public function render()
    {

        return view('livewire.admin.eleves.index', [
            'eleves' => $this->eleves
        ])
            ->layout(AdminLayout::class, ['title' => 'Liste d\'élèves']);
    }

}
