<?php

namespace App\Http\Livewire\Bibliotheque\Ouvrage;

use App\Http\Livewire\BaseComponent;
use App\Models\Lecture;
use App\Models\Ouvrage;
use App\Models\OuvrageCategory;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class OuvrageIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    // protected $paginationTheme = 'bootstrap';

    private $categories = [];
    private $ouvrages = [];
    public Ouvrage $ouvrage;

    protected $rules = [
        'ouvrage.ouvrage_category_id' => 'required',
        'ouvrage.titre' => 'required',
        'ouvrage.sous_titre' => 'nullable',
        'ouvrage.resume' => 'nullable',
        'ouvrage.edition' => 'nullable',
        'ouvrage.lieu' => 'nullable',
        'ouvrage.editeur' => 'nullable',
        'ouvrage.date' => 'nullable',
        'ouvrage.url' => 'required',
    ];

    public function mount()
    {
        $this->authorize("viewAny", Ouvrage::class);
        $this->initOuvrage();
        $this->loadData();
    }

    public function initOuvrage()
    {
        $this->ouvrage = new Ouvrage();
    }

    public function loadData()
    {
        $this->categories = OuvrageCategory::orderBy('nom')->get();
        $this->ouvrages = Ouvrage::orderBy('titre')->get();
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.bibliotheque.ouvrages.index', ['categories' => $this->categories, 'ouvrages'=>$this->ouvrages])
            ->layout(AdminLayout::class, ['title' => "Liste d'ouvrages"]);
    }


    public function addOuvrage()
    {
        $this->validate();

        try {
            $done = $this->ouvrage->save();
            if ($done) {
                $this->onModalClosed('add-ouvrage-modal');
                $this->loadData();
                $this->initOuvrage();
                $this->alert('success', "Ouvrage ajouté avec succès !");
            } else {
                $this->alert('warning', "Échec d'ajout d'ouvrage !");
            }
        } catch (Exception $exception) {
            //  dd($exception);
            $this->alert('error', "Échec de d'ajout d'ouvrage, ce titre existe déjà !");
        }

    }

    public function onModalClosed($p_id)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $p_id]);
        $this->initOuvrage();
    }

    public function getSelectedOuvrage(Ouvrage $ouvrage)
    {
        $this->ouvrage = $ouvrage;
    }

    public function updateOuvrage()
    {
        $this->validate();

        $done = $this->ouvrage->save();
        if ($done) {
            $this->onModalClosed('update-ouvrage-modal');
            $this->alert('success', "Ouvrage modifié avec succès !");
        } else {
            $this->alert('warning', "Échec de modification d'ouvrage !");
        }

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


    // Lectures
    public function addLecture($ouvrage_id)
    {
        $lecture = new Lecture();
        $lecture->user_id = \Auth::id()??null;
        $lecture->ouvrage_id = $ouvrage_id;

        try {
            $done = $lecture->save();
            $this->loadData();
        } catch (Exception $exception) {
            //  dd($exception);
        }

    }

}
