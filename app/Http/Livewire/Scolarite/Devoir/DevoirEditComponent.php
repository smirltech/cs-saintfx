<?php

namespace App\Http\Livewire\Scolarite\Devoir;


use App\Enums\MediaType;
use App\Exceptions\ApplicationAlert;
use App\Models\Classe;
use App\Models\Cours;
use App\Models\Devoir;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Livewire\Component;
use Livewire\WithFileUploads;

class DevoirEditComponent extends Component
{

    use ApplicationAlert, WithFileUploads;

    public Devoir $devoir;
    public Collection $cours;
    public Collection $classes;
    public UploadedFile|string|null $document = null;

    protected $messages = [
        'cours.nom.required' => 'Le nom est obligatoire',
        'cours.nom.unique' => 'Le nom existe déjà',
        'cours.description.required' => 'La description est requise',
        'cours.section_id.required' => 'La section est requise'
    ];

    public function submit()
    {
        $this->validate();

        $this->devoir->save();
        if ($this->document) {
            $this->devoir->addMedia(file: $this->document, mediaType: MediaType::devoir);
        }

        $this->alert('success', 'Cours modifiée avec succès');
    }


    public function mount(Devoir $devoir)
    {
        $this->devoir = $devoir;
        $this->cours = Cours::all();
        $this->classes = Classe::all();
    }


    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.devoirs.edit');
    }


    protected function rules(): array
    {
        return [
            'devoir.titre' => ['required', 'string'],
            'devoir.contenu' => ['required', 'string'],
            'devoir.classe_id' => ['required', 'integer'],
            'devoir.cours_id' => ['required', 'integer'],
            'devoir.echeance' => ['required', 'date'],
        ];
    }
}
