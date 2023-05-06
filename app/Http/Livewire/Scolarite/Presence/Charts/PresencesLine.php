<?php

namespace App\Http\Livewire\Scolarite\Presence\Charts;

use App\Models\Presence;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class PresencesLine extends Component
{
    public Collection $presences;

    public function mount(): void
    {
        $this->presences = Presence::all();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.scolarite.presence.charts.presences-line');
    }
}
