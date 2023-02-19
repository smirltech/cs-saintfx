<?php

namespace App\Http\Livewire\Bibliotheque\Ouvrage;

use App\Enums\MediaType;
use App\Models\Auteur;
use App\Models\Ouvrage;
use App\Models\OuvrageCategory;
use App\Models\Tag;
use App\Traits\HasLivewireAlert;
use App\Traits\WithFileUploads;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

class OuvrageCreateComponent extends Component
{
    use HasLivewireAlert, WithFileUploads;

    public Collection $categories;
    public Collection $auteurs;
    public Collection $tags;
    public Ouvrage $ouvrage;
    public $ouvrage_pdf;
    protected $listeners = ['refresh' => '$refresh'];
    protected $rules = [
        'ouvrage.ouvrage_category_id' => 'required|exists:ouvrage_categories,id',
        'ouvrage.titre' => 'required',
        'ouvrage.sous_titre' => 'nullable',
        'ouvrage.resume' => 'nullable',
        'ouvrage.edition' => 'nullable',
        'ouvrage.lieu' => 'nullable',
        'ouvrage.editeur' => 'nullable',
        'ouvrage.date' => 'nullable',
        'ouvrage.url' => 'nullable',
        'ouvrage.tags' => 'nullable|array',
        'ouvrage.auteurs' => 'nullable|array',
        'ouvrage_pdf' => 'nullable|mimes:pdf|max:10000',
    ];

    public function render(): Factory|View|Application
    {
        return view('livewire.bibliotheque.ouvrages.create')->with('title', 'Ajouter un ouvrage');
    }

    public function mount(Ouvrage $ouvrage): void
    {
        $this->ouvrage = $ouvrage;
        $this->categories = OuvrageCategory::orderBy('nom')->get();
        $this->tags = Tag::orderBy('name')->get();
        $this->auteurs = Auteur::all();
    }

    #[NoReturn] public function submit(): void
    {
        $id = $this->ouvrage->id;
        $this->ouvrage->save();

        if ($this->ouvrage_pdf) {
            $this->ouvrage->deleteAllMedia();
            $this->ouvrage->addMedia($this->ouvrage_pdf, MediaType::document->value);
            $this->reset('ouvrage_pdf');
        }
        $this->emit('refresh');
        if ($id) {
            $this->success("Ouvrage modifié avec succès !");
        } else {
            $this->flashSuccess("Ouvrage ajouté avec succès !", route('bibliotheque.ouvrages.edit', $this->ouvrage->id));
        }

    }

    public function addEtiquette()
    {

        $this->validate([
            'tag_id' => 'required',
        ]);

        try {
            $this->ouvrage_etiquette->save();

            $this->onModalClosed('add-etiquette-modal');
            $this->loadData();
            $this->initEtiquette();
            $this->ouvrage->refresh();
            $this->alert('success', "Etiquette ajoutée à ouvrage avec succès !");
        } catch (Exception $exception) {
            $this->error($exception->getMessage(), "Échec de d'ajout d'étiquette à ouvrage, il existe déjà !");
        }

    }

    public function initEtiquette()
    {
        $this->ouvrage_etiquette = new OuvrageEtiquette();

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


}
