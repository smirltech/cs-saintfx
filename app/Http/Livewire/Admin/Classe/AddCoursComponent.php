<?php

namespace App\Http\Livewire\Admin\Classe;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

class AddCoursComponent extends ModalComponent
{
    public function render(): Factory|View|Application
    {
        return view('livewire.admin.classes.modals.add-cours-component');
    }
}
