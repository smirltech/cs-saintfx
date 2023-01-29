<?php

namespace App\Http\Livewire\Bibliotheque\Ouvrage;

use App\Http\Livewire\BaseComponent;
use App\Models\Auteur;
use App\Models\Etiquette;
use App\Models\Lecture;
use App\Models\Ouvrage;
use App\Models\OuvrageAuteur;
use App\Models\OuvrageCategory;
use App\Models\OuvrageEtiquette;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class OuvrageShowComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public Ouvrage $ouvrage;
    public OuvrageAuteur $ouvrage_auteur;
    public OuvrageEtiquette $ouvrage_etiquette;
    public $categories = [];
    public $auteurs = [];

    public $etiquettes = [];

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

        'ouvrage_auteur.auteur_id' => 'nullable',
        'ouvrage_etiquette.etiquette_id' => 'nullable',
    ];

    public function mount(Ouvrage $ouvrage)
    {
        $this->authorize("view", $ouvrage);
        $this->ouvrage = $ouvrage;
        $this->ouvrage->lectures = $ouvrage->lectures;
       // dd($this->ouvrage);
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.bibliotheque.ouvrages.show')
            ->layout(AdminLayout::class, ['title' => "Détail sur l'ouvrage"]);
    }

    public function loadData()
    {
        $this->categories = OuvrageCategory::orderBy('nom', 'ASC')->get();
        $this->auteurs = Auteur::whereDoesntHave('ouvrage_auteur')->orderBy('nom', 'ASC')->get();


        $this->etiquettes = Etiquette::whereDoesntHave('ouvrage_etiquette')->orderBy('nom', 'ASC')->get();

        //  dd($this->categories);
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
        $this->category->refresh();
    }

    public function onModalClosed($p_id)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $p_id]);

    }


    // Auteurs

    public function initAuteur(){
        $this->ouvrage_auteur = new OuvrageAuteur();

    }
    public function addAuteur()
    {
        $this->ouvrage_auteur->ouvrage_id = $this->ouvrage->id;
        $this->validate([
            'ouvrage_auteur.auteur_id' => 'required',
        ]);

        try {
            $done = $this->ouvrage_auteur->save();
            if ($done) {
                $this->onModalClosed('add-auteur-modal');
                $this->loadData();
                $this->initAuteur();
                $this->ouvrage->refresh();
                $this->alert('success', "Auteur ajouté à ouvrage avec succès !");
            } else {
                $this->alert('warning', "Échec d'ajout d'auteur à ouvrage !");
            }
        } catch (Exception $exception) {
            //  dd($exception);
            $this->alert('error', "Échec de d'ajout d'auteur à ouvrage, il existe déjà !");
        }

    }

    public function deleteAuteur($id)
    {

        try {
            $done = OuvrageAuteur::find($id)->delete();
            if ($done) {

                $this->ouvrage->refresh();
                $this->loadData();
                $this->initAuteur();
                $this->alert('success', "Auteur supprimé de l'ouvrage avec succès !");
            } else {
                $this->alert('warning', "Échec de suppression d'auteur de l'ouvrage !");
            }
        } catch (Exception $exception) {
            //  dd($exception);
            $this->alert('error', "Échec de de suppression d'auteur de l'ouvrage !");
        }

    }


    // Etiquettes

    public function initEtiquette(){
        $this->ouvrage_etiquette = new OuvrageEtiquette();

    }
    public function addEtiquette()
    {
        $this->ouvrage_etiquette->ouvrage_id = $this->ouvrage->id;
        $this->validate([
            'ouvrage_etiquette.etiquette_id' => 'required',
        ]);

        try {
            $done = $this->ouvrage_etiquette->save();
            if ($done) {
                $this->onModalClosed('add-etiquette-modal');
                $this->loadData();
                $this->initEtiquette();
                $this->ouvrage->refresh();
                $this->alert('success', "Etiquette ajoutée à ouvrage avec succès !");
            } else {
                $this->alert('warning', "Échec d'ajout d'étiquette à ouvrage !");
            }
        } catch (Exception $exception) {
            //  dd($exception);
            $this->alert('error', "Échec de d'ajout d'étiquette à ouvrage, il existe déjà !");
        }

    }

    public function deleteEtiquette($id)
    {

        try {
            $done = OuvrageEtiquette::find($id)->delete();
            if ($done) {

                $this->ouvrage->refresh();
                $this->loadData();
                $this->initEtiquette();
                $this->alert('success', "Etiquette supprimée de l'ouvrage avec succès !");
            } else {
                $this->alert('warning', "Échec de suppression d'étiquette de l'ouvrage !");
            }
        } catch (Exception $exception) {
            //  dd($exception);
            $this->alert('error', "Échec de de suppression d'étiquette de l'ouvrage !");
        }

    }


    public function addLecture()
    {
        $lecture = new Lecture();
        $lecture->user_id = \Auth::id()??null;
        $lecture->ouvrage_id = $this->ouvrage->id;

        try {
            $done = $lecture->save();
            $this->ouvrage->refresh();
        } catch (Exception $exception) {
            //  dd($exception);
        }

    }

}
