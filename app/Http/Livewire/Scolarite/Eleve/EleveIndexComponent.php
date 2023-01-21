<?php

namespace App\Http\Livewire\Scolarite\Eleve;

use App\Http\Livewire\BaseComponent;
use App\Models\Eleve;
use App\Traits\FakeProfileImage;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class EleveIndexComponent extends BaseComponent
{
    use TopMenuPreview, FakeProfileImage;

    public $eleves = [];


    /**
     * @throws AuthorizationException
     */
    public function mount()
    {
        $this->authorize('viewAny', Eleve::class);
        $this->loadData();
    }

    public function loadData()
    {
        $this->eleves = Eleve::orderBy('nom')->get();
        $this->setFakeProfileImageUrl();
    }

    public function render(): View|Factory|Application
    {

        return view('livewire.scolarite.eleves.index', [
            'eleves' => $this->eleves
        ])
            ->layout(AdminLayout::class, ['title' => 'Liste d\'élèves']);
    }

}
