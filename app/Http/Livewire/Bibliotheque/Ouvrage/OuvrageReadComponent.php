<?php

namespace App\Http\Livewire\Bibliotheque\Ouvrage;

use App\Enums\MediaType;
use App\Models\Ouvrage;
use App\Models\OuvrageCategory;
use App\Traits\HasLivewireAlert;
use App\Traits\WithFileUploads;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

class OuvrageReadComponent extends Component
{
    use HasLivewireAlert, WithFileUploads;

    public Collection $categories;
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

}
