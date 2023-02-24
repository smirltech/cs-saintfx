<?php

namespace App\Http\Livewire\Bibliotheque\OuvrageCategory;

use App\Http\Livewire\BaseComponent;
use App\Models\OuvrageCategory;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class OuvrageCategoryShowComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public OuvrageCategory $category;
    public $categories = [];

    protected $rules = [
        'category.nom' => 'required',
        'category.rayon_id' => 'nullable',
        'category.description' => 'nullable',
    ];

    public function mount(OuvrageCategory $category)
    {
        $this->authorize("view", $category);
        $this->category = $category;
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.bibliotheque.categories.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur la catégorie']);
    }

    public function loadData()
    {
        $this->categories = OuvrageCategory::where('id', '!=', $this->category->id)->orderBy('nom', 'ASC')->get();
        //  dd($this->categories);
    }

    public function updateCategory()
    {
        $this->validate();

        $done = $this->category->save();
        if ($done) {
            $this->onModalClosed('update-category-modal');
            $this->alert('success', "Catégorie modifiée avec succès !");
        } else {
            $this->alert('warning', "Échec de modification de catégorie !");
        }
        $this->category->refresh();
    }

    public function onModalClosed($p_id)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $p_id]);

    }

}
