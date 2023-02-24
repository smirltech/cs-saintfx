<?php

namespace App\Http\Livewire\Bibliotheque\OuvrageCategory;

use App\Http\Livewire\BaseComponent;
use App\Models\OuvrageCategory;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class OuvrageCategoryIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    // protected $paginationTheme = 'bootstrap';

    public OuvrageCategory $category;
    protected $rules = [
        'category.nom' => 'required',
        'category.rayon_id' => 'nullable',
        'category.description' => 'nullable',
    ];
    private $categories = [];

    public function mount()
    {
        $this->authorize("viewAny", OuvrageCategory::class);
        $this->initCategory();
        $this->loadData();
    }

    public function initCategory()
    {
        $this->category = new OuvrageCategory();
    }

    public function loadData()
    {
        $this->categories = OuvrageCategory::orderBy('nom')->get();
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.bibliotheque.categories.index', ['categories' => $this->categories])
            ->layout(AdminLayout::class, ['title' => "Liste de Categories"]);
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
        $this->initCategory();
    }

    public function getSelectedCategory(OuvrageCategory $category)
    {
        $this->category = $category;
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

    }

    public function deleteCategory()
    {
        try {
            $this->category->delete();
            $this->loadData();
            $this->alert('success', "Catégorie supprimée avec succès !");

        } catch (Exception $e) {
            $this->alert('warning', "Cette catégorie n'a pas été supprimée, il y a des ouvrages attachés !");
        }

        $this->onModalClosed('delete-category-modal');

    }

}
