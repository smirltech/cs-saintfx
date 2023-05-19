<?php

namespace App\Http\Livewire\Bibliotheque\Ouvrage;

use App\Http\Livewire\BaseComponent;
use App\Models\Lecture;
use App\Models\Ouvrage;
use App\Models\Rayon;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Auth;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class OuvrageIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    private $ouvrages = [];

    /**
     * @throws AuthorizationException
     */
    public function mount(): void
    {
        $this->authorize("viewAny", Ouvrage::class);
        $this->loadData();
    }

    public function loadData(): void
    {
        $this->categories = Rayon::orderBy('nom')->get();
        $this->ouvrages = Ouvrage::latest()->get();
    }

    public function render(): View|Factory|Application
    {
        $this->loadData();
        return view('livewire.bibliotheque.ouvrages.index', ['rayons' => $this->categories, 'ouvrages' => $this->ouvrages])
            ->layout(AdminLayout::class, ['title' => "Liste d'ouvrages"]);
    }

    public function getSelectedOuvrage(Ouvrage $ouvrage): void
    {
        $this->ouvrage = $ouvrage;
    }

    public function deleteOuvrage(): void
    {
        try {
            $this->ouvrage->delete();
            $this->loadData();
            $this->alert('success', "Ouvrage supprimé avec succès !");

        } catch (Exception $e) {
            $this->alert('warning', "Cet ouvrage n'a pas été supprimé, il y a des ouvrages attachés !");
        }

        $this->onModalClosed('delete-ouvrage-modal');

    }


    // Lectures

    public function addLecture($ouvrage_id): void
    {
        // dd($ouvrage_id);
        $lecture = new Lecture();
        $lecture->user_id = Auth::id() ?? null;
        $lecture->ouvrage_id = $ouvrage_id;

        try {
            $done = $lecture->save();
            $this->loadData();
        } catch (Exception $exception) {
            dd($exception);
        }

    }

}
