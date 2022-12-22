<?php

namespace App\Http\Livewire\Scolarite\Devoir;


use App\Enums\MediaType;
use App\Exceptions\ApplicationAlert;
use App\Models\Classe;
use App\Models\Cours;
use App\Models\Devoir;
use App\Traits\CanDeleteModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use Livewire\WithFileUploads;

class DevoirCreateComponent extends Component
{

    use ApplicationAlert, WithFileUploads, CanDeleteModel;

    public Devoir $devoir;
    public Collection $cours;
    public Collection $classes;
    public UploadedFile|string|null $document = null;

    protected $messages = [
        'devoir.titre.required' => 'Le titre est obligatoire',
        'devoir.contenu.required' => 'Le contenu est obligatoire',
        'devoir.echeance.required' => 'L\'échéance est obligatoire',
        'devoir.cours_id.required' => 'Le cours est obligatoire',
        'devoir.classe_id.required' => 'La classe est obligatoire',
        'document.max' => 'Le fichier ne doit pas dépasser 2Mo',
    ];

    #[NoReturn] public function submit()
    {
        $this->validate();

        $this->devoir->save();
        if ($this->document) {
            $this->devoir->addMedia(file: $this->document, mediaType: MediaType::document);
        }

        $this->alert('success', 'Devoir créé avec succès');
    }

    public function render(): Factory|View|Application
    {

        return view('livewire.scolarite.devoirs.create');
    }

    public function mount()
    {
        $this->devoir = new Devoir();
        $this->cours = Cours::all();
        $this->classes = Classe::all();
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
