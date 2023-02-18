<?php

namespace App\Http\Livewire\Bibliotheque\Etiquette;

use App\Http\Livewire\BaseComponent;
use App\Models\Tag;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EtiquetteIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    // protected $paginationTheme = 'bootstrap';

    public Tag $etiquette;
    protected $rules = [
        'etiquette.nom' => 'required|unique:tags, nom',
    ];
    private $etiquettes = [];

    /**
     * @throws AuthorizationException
     */
    public function mount(): void
    {
        $this->authorize("viewAny", Tag::class);
        $this->initEtiquette();
        $this->loadData();
    }

    public function initEtiquette(): void
    {
        $this->etiquette = new Tag();
    }

    public function loadData(): void
    {
        $this->etiquettes = Tag::orderBy('name')->get();
    }

    public function render(): Factory|View|Application
    {
        $this->loadData();
        return view('livewire.bibliotheque.tags.index', ['etiquettes' => $this->etiquettes])
            ->layout(AdminLayout::class, ['title' => "Liste d'Étiquettes"]);
    }


    public function addEtiquette()
    {
        $this->validate();

        try {
            $done = $this->etiquette->save();
            if ($done) {
                $this->onModalClosed('add-etiquette-modal');
                $this->loadData();
                $this->initEtiquette();
                $this->alert('success', "Étiquette ajoutée avec succès !");
            } else {
                $this->alert('warning', "Échec d'ajout de étiquette !");
            }
        } catch (Exception $exception) {
            //  dd($exception);
            $this->alert('error', "Échec de d'ajout d'étiquette, ce nom existe déjà !");
        }

    }

    public function onModalClosed($p_id)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $p_id]);
        $this->initEtiquette();
    }

    public function getSelectedEtiquette(Tag $etiquette)
    {
        $this->etiquette = $etiquette;
    }

    public function updateEtiquette()
    {
        $this->validate([
            'etiquette.nom' => [
                "required",
                Rule::unique((new Tag())->getTable(), "nom")->ignore($this->etiquette->id)
            ],

        ]);

        $done = $this->etiquette->save();
        if ($done) {
            $this->onModalClosed('update-etiquette-modal');
            $this->alert('success', "Étiquette modifiée avec succès !");
        } else {
            $this->alert('warning', "Échec de modification d'étiquette !");
        }

    }

    public function deleteEtiquette()
    {
        if ($this->etiquette->delete()) {
            $this->loadData();
            $this->alert('success', "Étiquette supprimée avec succès !");
        } else {
            $this->alert('warning', "Étiquette n'a pas été supprimée, il y a des éléments attachés !");
        }
        $this->onModalClosed('delete-etiquette-modal');

    }

}
