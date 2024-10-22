<?php

namespace App\Http\Livewire\Scolarite\Presence;

use App\Http\Livewire\BaseComponent;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Section;
use App\Traits\FakeProfileImage;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class PresencesIndexComponent extends BaseComponent
{
    use TopMenuPreview, FakeProfileImage;

    public $eleves = [];


    /**
     * @throws AuthorizationException
     */
    public function mount(): void
    {
        $this->eleves = Eleve::orderBy('created_at','desc')->get();
        $this->sections = Section::all();
        $this->classes = Classe::all();
    }


    public function render(): View|Factory|Application
    {

        return view('livewire.scolarite.presences.index')
            ->layout(AdminLayout::class, ['title' => 'Liste des présences']);
    }

}
