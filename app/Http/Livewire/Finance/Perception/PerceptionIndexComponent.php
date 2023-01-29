<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Http\Integrations\Scolarite\Requests\Annee\GetCurrentAnnneRequest;
use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Perception;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PerceptionIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $perceptions = [];
    public $perception;

    public function mount()
    {
        $this->authorize('viewAny', Perception::class);

        $this->annee_id = Annee::id();

    }

    public function render()
    {
        $perceptionsRequest = Perception::where('annee_id', $this->annee_id);
        $this->perceptions = $perceptionsRequest->orderBy('created_at', 'DESC')->get();
        // dd($this->perceptions);
        return view('livewire.finance.perceptions.index', ['perceptions' => $this->perceptions])
            ->layout(AdminLayout::class, ['title' => 'Liste de Perceptions']);
    }

    public function getSelectedPerception(int $id)
    {
        $this->perception = Perception::find($id);

    }

    public function deletePerception()
    {

        if ($this->perception->delete()) {
            $this->alert('success', "Perception supprimée avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-perception']);
        }

        $this->onModalClosed();

    }

    public function onModalClosed()
    {
        // $this->clearValidation();
        //$this->reset(['categorie', 'montant', 'note', 'reference']);
    }

}
