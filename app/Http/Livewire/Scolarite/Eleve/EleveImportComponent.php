<?php

namespace App\Http\Livewire\Scolarite\Eleve;

use App\Http\Livewire\BaseComponent;
use App\Imports\EtudiantsImport;
use App\Models\Annee;
use App\Models\Eleve;
use App\Models\Section;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\WithFileUploads;

class EleveImportComponent extends BaseComponent
{

    use WithFileUploads;

    public mixed $fiche = null;
    public string $title;


    public Collection $annees;
    public Collection $sections;
    public array|Collection $options = [];
    public array|Collection $classes = [];
    protected $listeners = ['confirmed' => 'confirmed'];


    /**
     * @throws AuthorizationException
     */
    public function mount(): void
    {
        $this->authorize('create', Eleve::class);
        $this->title = 'Impomrter la liste d\'élèves';
        $this->annees = Annee::all();
        $this->sections = Section::all();
    }


    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.eleve.eleve-import-component')->layoutData(['title' => $this->title]);
    }

    // submit form

    /**
     * @throws Exception
     */
    public function submit(): void
    {       // confirm dialog
        $this->confirm('Confirmez l\'envoi de la grille pour l\'année ' . $this->annee . ', promotion ' . $this->promotion, [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => "Annuler",
            'confirmButtonText' => "Confirmer",
            'onConfirmed' => 'confirmed',
            'onCancelled' => 'cancelled'
        ]);
        $this->confirmed();
    }

    // con

    // confirmed submit
    /**
     * @throws Exception
     */
    public function confirmed(): void
    {
        try {
            $this->emit('hideModal');
            EtudiantsImport::build()->import($this->file->getRealPath());
            $this->success('Liste des étudiants importée avec succès');
            $this->emitUp('refresh');
        } catch (Exception $e) {
            $this->error($e->getMessage(), $e->getMessage());
        }
    }

    // rules()
    public function rules(): array
    {
        return [
            'file' => 'required|mimes:xlsx',
            'fiche.annee' => 'required',
            'fiche.section' => 'required',
            'fiche.option' => 'nullable',
            'fiche.classe' => 'required',
        ];
    }

    // updatedFicheSection
    public function updatedFicheSection($value): void
    {
        $section = $this->sections->find($value);
        $this->options = $section->options;
        $this->classes = $section->classes;

        $this->emit('$refresh');
    }

    // updatedFicheOption
    public function updatedFicheOption($value): void
    {
        $this->classes = $this->options->find($value)->classes;
    }

}
