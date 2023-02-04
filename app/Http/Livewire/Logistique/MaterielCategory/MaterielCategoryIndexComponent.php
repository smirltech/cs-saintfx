<?php

namespace App\Http\Livewire\Logistique\MaterielCategory;

use App\Models\MaterielCategory;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MaterielCategoryIndexComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;

    public $categories = [];
    public MaterielCategory $category;

    protected $rules = [
        'category.nom' => 'required|unique:materiel_categories, nom',
        'category.materiel_category_id' => 'nullable',
        'category.description' => 'nullable',
    ];

    public function mount()
    {
        $this->initCategory();
    }

    public function initCategory()
    {
        $this->category = new MaterielCategory();
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.logistiques.materiel_categories.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Categories des Matériels']);
    }

    public function loadData()
    {
        $this->categories = MaterielCategory::orderBy('nom', 'ASC')->get()/* ->sortBy('groupe_nom')*/
        ;
        //  dd($this->categories);
    }

    public function addCategory()
    {
        $this->validate();

        try {
            $done = $this->category->save();
            if ($done) {
                $this->onModalClosed('add-category-modal');
                $this->loadData();
                $this->initCategory();
                $this->alert('success', "Catégorie ajoutée avec succès !");
            } else {
                $this->alert('warning', "Échec d'ajout de catégorie !");
            }
        } catch (Exception $exception) {
            //  dd($exception);
            $this->alert('error', "Échec de d'ajout de catégorie, ce nom existe déjà !");
        }

    }

    public function onModalClosed($p_id)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $p_id]);

    }

    public function getSelectedCategory(MaterielCategory $category)
    {
        $this->category = $category;
        // dd($this->category->categories);
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

    }

    public function deleteCategory()
    {
        if ($this->category->categories->count() == 0 && $this->category->materiels->count() == 0) {
            if ($this->category->delete()) {
                $this->loadData();
                $this->alert('success', "Catégorie supprimée avec succès !");
            }
        } else {
            $this->alert('warning', "Catégorie n'a pas été supprimée, il y a des éléments attachés !");
        }
        $this->onModalClosed('delete-category-modal');

    }
}
