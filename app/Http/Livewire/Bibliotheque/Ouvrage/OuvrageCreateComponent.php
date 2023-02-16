<?php

namespace App\Http\Livewire\Bibliotheque\Ouvrage;

use App\Models\Ouvrage;
use App\Models\OuvrageCategory;
use App\Traits\HasLivewireAlert;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class OuvrageCreateComponent extends Component
{
    use HasLivewireAlert;

    public Collection $categories;
    public Ouvrage $ouvrage;

    protected $rules = [
        'ouvrage.ouvrage_category_id' => 'required',
        'ouvrage.titre' => 'required',
        'ouvrage.sous_titre' => 'nullable',
        'ouvrage.resume' => 'nullable',
        'ouvrage.edition' => 'nullable',
        'ouvrage.lieu' => 'nullable',
        'ouvrage.editeur' => 'nullable',
        'ouvrage.date' => 'nullable',
        'ouvrage.url' => 'required',
    ];

    public function render(): Factory|View|Application
    {
        return view('livewire.bibliotheque.ouvrages.create');
    }

    public function mount(Ouvrage $ouvrage): void
    {
        $this->ouvrage = $ouvrage;
        $this->categories = OuvrageCategory::orderBy('nom')->get();
    }

    public function submit(): void
    {
        $this->validate();
        $id = $this->ouvrage->id;
        $this->ouvrage->save();
        
        $this->emit('hideModal');
        $this->emit('refresh');
        if ($id) {
            $this->success("Ouvrage modifié avec succès !");
        } else {
            $this->success("Ouvrage ajouté avec succès !");
        }

    }

}
