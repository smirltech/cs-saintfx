<?php

namespace App\Http\Livewire\Bibliotheque\Ouvrage;

use App\Models\OuvrageCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_OuvrageCategory_C;
use Livewire\Component;

class OuvrageCreateComponent extends Component
{
    /**
     * @var OuvrageCategory[]|_IH_OuvrageCategory_C
     */
    public Collection $categories;

    public function render(): Factory|View|Application
    {
        return view('livewire.bibliotheque.ouvrages.create');
    }

    public function mount(): void
    {
        $this->categories = OuvrageCategory::orderBy('nom')->get();
    }
}
