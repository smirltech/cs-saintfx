<?php

namespace App\Http\Livewire\Scolarite\Devoir;


use App\Enums\MediaType;
use App\Exceptions\ApplicationAlert;
use App\Models\Cours;
use App\Models\Devoir;
use App\Traits\CanDeleteMedia;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class DevoirShowComponent extends Component
{

    use ApplicationAlert, WithFileUploads, CanDeleteMedia;

    public Devoir $devoir;
    public Cours $cours;
    public TemporaryUploadedFile|string|null $document = null;
    public $documents = [];
    public ?Collection $reponses;

    protected $listeners = [
        'deleteConfirmed',
    ];


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
        $this->refreshData();
        $this->alert('success', 'Cours modifiée avec succès');
    }

    private function refreshData(): void
    {
        $this->devoir->refresh();
        $this->reponses = $this->devoir->reponses;
    }


    // delete media

    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.devoirs.show');
    }

    public function mount(Devoir $devoir)
    {
        $this->devoir = $devoir;
        $this->cours = $this->devoir->cours;
    }


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
