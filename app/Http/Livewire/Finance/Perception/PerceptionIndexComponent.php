<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Enums\UserRole;
use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Consommable;
use App\Models\Depense;
use App\Models\Enseignant;
use App\Models\Frais;
use App\Models\Inscription;
use App\Models\Materiel;
use App\Models\Perception;
use App\Models\User;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Redirector;

class PerceptionIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $perception;

    public string $classe_id = '';
    public string $annee_id = '';
    public string $frais_id = '';

    public function mount(): void
    {
        $this->authorize('viewAny', Perception::class);

        $this->classe_id = request()->get('classe_id') ?: '';
        $this->frais_id = request()->get('frais_id') ?: '';

        $this->annee_id = Annee::id();
        $this->classes = Classe::all();
        $this->frais = Frais::all();

    }

    public function getBoxesProperty(): array
    {

        $perceptionQuery = Perception::when($this->classe_id, function ($q) {
            $q->whereHas('inscription', function ($q) {
                $q->where('classe_id', $this->classe_id);
            });
        })->when($this->frais_id, function ($q) {
            $q->where('frais_id', $this->frais_id);
        });

        $perceptionsUSD = $perceptionQuery->whereDevise('USD')->sum('montant');
        $perceptionsCDF = $perceptionQuery->whereDevise('CDF')->sum('montant');

        $perceptionsTodayUSD = $perceptionQuery->whereDevise('USD')->sum('montant');
        $perceptionsTodayCDF = $perceptionQuery->whereDevise('CDF')->sum('montant');

        $perceptionsMeTodayUSD = $perceptionQuery->whereDevise('USD')->whereUserId(Auth::id())->sum('montant');
        $perceptionsMeTodayCDF = $perceptionQuery->whereDevise('CDF')->whereUserId(Auth::id())->sum('montant');


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

        return view('livewire.finance.perceptions.index', ['perceptions' => $this->perceptions])
            ->layout(AdminLayout::class, ['title' => 'Liste de Perceptions']);
    }

    public function getPerceptionsProperty(): Collection
    {
        $perceptionsRequest = Perception::when($this->classe_id, function ($q) {
            $q->whereHas('inscription', function ($q) {
                $q->where('classe_id', $this->classe_id);
            });
        })->when($this->frais_id, function ($q) {
            $q->where('frais_id', $this->frais_id);
        });

        return $this->perceptions = $perceptionsRequest->latest()->get();
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

    public function search(): RedirectResponse|Redirector
    {
        return redirect()->route('finance.perceptions', [
            'classe_id' => $this->classe_id,
            'frais_id' => $this->frais_id,
        ]);
    }


}
