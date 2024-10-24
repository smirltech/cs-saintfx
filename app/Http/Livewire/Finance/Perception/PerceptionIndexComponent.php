<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Enums\UserRole;
use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Consommable;
use App\Models\Depense;
use App\Models\Enseignant;
use App\Models\Inscription;
use App\Models\Materiel;
use App\Models\Perception;
use App\Models\User;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PerceptionIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $perceptions = [];
    public $perception;

    public function mount(): void
    {
        $this->authorize('viewAny', Perception::class);

        $this->annee_id = Annee::id();

    }

    public function getBoxesProperty(): array
    {
        $perceptionsUSD =Perception::whereDevise('USD')->sum('montant');
        $perceptionsCDF = Perception::whereDevise('CDF')->sum('montant');

        $perceptionsTodayUSD =Perception::ofToday()->whereDevise('USD')->sum('montant');
        $perceptionsTodayCDF = Perception::ofToday()->whereDevise('CDF')->sum('montant');

        $perceptionsMeTodayUSD =Perception::ofToday()->whereDevise('USD')->whereUserId(Auth::id())->sum('montant');
        $perceptionsMeTodayCDF = Perception::ofToday()->whereDevise('CDF')->whereUserId(Auth::id())->sum('montant');


        return [
            [
                'title' => "{$perceptionsCDF}Fc / {$perceptionsUSD}$",
                'text' => 'Perceptions',
                'icon' => 'fas fa-coins',
                'theme' => 'gradient-success',
                'url' => \route('finance.perceptions')

            ],
            [
                'title' => "{$perceptionsTodayCDF}Fc / {$perceptionsTodayUSD}$",
                'text' => "Aujoud'hui",
                'icon' => 'fas fa-coins',
                'theme' => 'gradient-success',
                'url' => \route('finance.perceptions')

            ],
            [
                'title' => '$' . Depense::total(),
                'text' => 'Depenses',
                'icon' => 'fas fa-credit-card',
                'theme' => 'gradient-danger',
                'url' => '#'

            ],
            [
                'title' => "{$perceptionsMeTodayCDF}Fc / {$perceptionsMeTodayUSD}$",
                'text' => "Aujoud'hui",
                'icon' => 'fas fa-user',
                'theme' => 'gradient-success',
                'url' => \route('finance.perceptions')

            ],
        ];
    }

    public function render()
    {
        $perceptionsRequest = Perception::where('annee_id', $this->annee_id);
        $this->perceptions = $perceptionsRequest->latest()->get();

        return view('livewire.finance.perceptions.index', ['perceptions' => $this->perceptions])
            ->layout(AdminLayout::class, ['title' => 'Liste de Perceptions']);
    }

    public function getSelectedPerception(Perception $perception): void
    {
        $this->perception = $perception;

    }

    public function deletePerception(): void
    {

        if ($this->perception->delete()) {
            $this->alert('success', "Perception supprimée avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-perception']);
        }

        $this->onModalClosed();

    }


}
