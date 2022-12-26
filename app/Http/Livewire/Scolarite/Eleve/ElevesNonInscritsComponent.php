<?php

namespace App\Http\Livewire\Scolarite\Eleve;

use App\Models\Eleve;
use App\Traits\FakeProfileImage;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ElevesNonInscritsComponent extends Component
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
        $this->eleves = Eleve::nonInscritsAnneeEnCours();
        $this->setFakeProfileImageUrl();
    }

    public function render()
    {

        return view('livewire.scolarite.eleves.non_inscrits', [
            'eleves' => $this->eleves
        ])
            ->layout(AdminLayout::class, ['title' => 'Liste d\'élèves']);
    }

}
