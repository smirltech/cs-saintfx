<?php

namespace App\Http\Livewire\Bibliotheque\Ouvrage;

use App\Http\Livewire\BaseComponent;
use App\Models\Lecture;
use App\Models\Ouvrage;
use App\Models\OuvrageCategory;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Auth;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class OuvrageIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    private $ouvrages = [];

    public function mount()
    {
        $this->authorize("viewAny", Ouvrage::class);
        $this->loadData();
    }

    public function loadData()
    {
        $this->categories = OuvrageCategory::orderBy('nom')->get();
        $this->ouvrages = Ouvrage::orderBy('titre')->get();
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.bibliotheque.ouvrages.index', ['categories' => $this->categories, 'ouvrages' => $this->ouvrages])
            ->layout(AdminLayout::class, ['title' => "Liste d'ouvrages"]);
    }

    public function getSelectedOuvrage(Ouvrage $ouvrage)
    {
        $this->ouvrage = $ouvrage;
    }

    public function deleteOuvrage()
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

    public function onModalClosed($p_id)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $p_id]);
        $this->initOuvrage();
    }


    // Lectures

    public function addLecture($ouvrage_id)
    {
        $lecture = new Lecture();
        $lecture->user_id = Auth::id() ?? null;
        $lecture->ouvrage_id = $ouvrage_id;

        try {
            $done = $lecture->save();
            $this->loadData();
        } catch (Exception $exception) {
            //  dd($exception);
        }

    }

}
