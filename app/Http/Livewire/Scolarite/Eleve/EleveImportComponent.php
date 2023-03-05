<?php

namespace App\Http\Livewire\Scolarite\Eleve;

use App\Http\Livewire\BaseComponent;
use App\Imports\EtudiantsImport;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Eleve;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\WithFileUploads;

class EleveImportComponent extends BaseComponent
{

    use WithFileUploads;

    public mixed $file = null;
    public string $annee;
    public string $classe;
    protected $listeners = ['confirmed' => 'confirmed'];

    /**
     * @throws AuthorizationException
     */
    public function mount(): void
    {
        $this->authorize('create', Eleve::class);
        $this->title = 'Impomrter la liste d\'élèves';
        $this->annees = Annee::all();
        $this->classes = Classe::all();
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
    {

        try {
            // $this->emit('hideModal');
            EtudiantsImport::build()->import($this->file->getRealPath());
            $this->success('Liste des étudiants importée avec succès');
            $this->emitUp('refresh');
        } catch (Exception $e) {
            $this->error($e->getMessage(), $e->getMessage());
        }// confirm dialog
        /*$this->confirm('Confirmez l\'envoi de la grille pour l\'année ' . $this->annee . ', promotion ' . $this->promotion, [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => "Annuler",
            'confirmButtonText' => "Confirmer",
            'onConfirmed' => 'confirmed',
            'onCancelled' => 'cancelled'
        ]);
        $this->confirmed();*/
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
            'annee' => 'required',
            'classe' => 'required',
        ];
    }

}
