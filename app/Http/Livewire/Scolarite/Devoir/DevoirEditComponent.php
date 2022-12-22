<?php

namespace App\Http\Livewire\Scolarite\Devoir;


use App\Enums\MediaType;
use App\Exceptions\ApplicationAlert;
use App\Models\Classe;
use App\Models\Devoir;
use App\Models\Media;
use App\Traits\CanDeleteModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class DevoirEditComponent extends Component
{

    use ApplicationAlert, WithFileUploads, CanDeleteModel;

    public Devoir $devoir;
    public Collection|array $cours = [];
    public Collection $classes;
    public TemporaryUploadedFile|string|null $document = null;
    public $documents = [];
    public ?Collection $reponses;


    protected $messages = [
        'devoir.titre.required' => 'Le titre est obligatoire',
        'devoir.contenu.required' => 'Le contenu est obligatoire',
        'devoir.echeance.required' => 'L\'échéance est obligatoire',
        'devoir.cours_id.required' => 'Le cours est obligatoire',
        'devoir.classes_id.required' => 'La classe est obligatoire',
        'document.max' => 'Le fichier ne doit pas dépasser 2Mo',
    ];

    public function submit()
    {
        $this->validate();

        $this->devoir->save();
        if ($this->document) {
            $this->devoir->addMedia(file: $this->document, mediaType: MediaType::document);
        }

        $this->alert('success', 'Cours modifiée avec succès');
    }

    public function deleteMedia(Media $media): void
    {
        if ($media->delete()) {
            $this->alert('success', 'Document supprimé avec succès');
        } else {
            $this->alert('error', 'Une erreur s\'est produite lors de la suppression du document');
        }
    }

    public function updatedDevoirClasseId($value): void
    {
        $classe = Classe::find($value);
        $this->cours = $classe->cours;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.devoirs.edit');
    }

    public function mount(Devoir $devoir)
    {
        $this->devoir = $devoir;
        $this->classes = Classe::has('cours')->get();
        $this->reponses = $devoir->reponses;
        $this->cours = $this->devoir->classe->cours;
    }

    // delete media

    protected function rules(): array
    {
        return [
            'devoir.titre' => ['required', 'string'],
            'devoir.contenu' => ['required', 'string'],
            'devoir.classe_id' => ['required', 'integer'],
            'devoir.cours_id' => ['required', 'integer'],
            'devoir.echeance' => ['required', 'date'],
            'document' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ];
    }

}
