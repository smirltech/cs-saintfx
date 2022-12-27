<?php

namespace App\Http\Livewire\Scolarite\Devoir;


use App\Enums\MediaType;
use App\Exceptions\ApplicationAlert;
use App\Models\Cours;
use App\Models\Devoir;
use App\Models\Eleve;
use App\Traits\CanDeleteMedia;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Str;

class DevoirShowComponent extends Component
{

    use ApplicationAlert, WithFileUploads, CanDeleteMedia;

    public Devoir $devoir;
    public Cours $cours;
    public TemporaryUploadedFile|string|null $document = null;
    public $documents = [];
    public string $matricule = "";
    public ?Collection $reponses;
    public ?Eleve $eleve;

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

    public function updatedMatricule()
    {
        if (Str::length($this->matricule) == 10) {
            $this->validate([
                'matricule' => ['required', 'string', 'exists:eleves,matricule'],
            ]);
            //2022030003
            $this->eleve = Eleve::hasWhere('inscriptions', function ($query) {
                $query->where('classe_id', $this->devoir->classe_id)
                    ->where('annee_id', $this->devoir->annee_id);
            })->where('matricule', $this->matricule)->first();

            if (!$this->eleve) {
                $this->alert('error', "L'élève n'est pas inscrit dans cette classe");
            }
        } /*else {
            $this->validate([
                'matricule' => ['required', 'string', 'digits:10']
            ]);
            $this->eleve = new Eleve();
        }*/
    }

    // update matricule

    protected function rules(): array
    {
        return [
            'devoir_reponse.contenu' => ['required', 'string'],
            'document' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ];
    }

}
