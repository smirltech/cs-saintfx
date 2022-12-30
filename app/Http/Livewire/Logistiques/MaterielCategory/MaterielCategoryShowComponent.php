<?php

namespace App\Http\Livewire\Logistiques\MaterielCategory;

use App\Models\MaterielCategory;
use App\Models\Option;
use App\Models\Section;
use App\Traits\SectionCode;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MaterielCategoryShowComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;

    public MaterielCategory $category;
    public $categories = [];

    protected $rules = [
        'category.nom' => 'required|unique:materiel_categories, nom',
        'category.materiel_category_id' => 'nullable',
        'category.description' => 'nullable',
    ];

    public function mount(MaterielCategory $category)
    {
        $this->category = $category;
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.logistiques.materiel_categories.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur la catégorie de matériel']);
    }

    public function loadData()
    {
        $this->categories = MaterielCategory::where('id','!=', $this->category->id)->orderBy('nom', 'ASC')->get();
        //  dd($this->categories);
    }

    public function onModalClosed($p_id)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $p_id]);

    }

    public function updateCategory()
    {
        $this->validate([
            'category.nom' => [
                "required",
                Rule::unique((new MaterielCategory())->getTable(), "nom")->ignore($this->category->id)
            ],
            'category.description' => 'nullable',
            'category.materiel_category_id' => 'nullable',
        ]);

        $done = $this->category->save();
        if ($done) {
            $this->onModalClosed('update-category-modal');
            $this->alert('success', "Catégorie modifiée avec succès !");
        } else {
            $this->alert('warning', "Échec de modification de catégorie !");
        }
        $this->category->refresh();
    }


}
