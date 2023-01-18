<?php

namespace App\Http\Livewire\Profile;

use App\Traits\WithFileUploads;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\UploadedFile;
use Livewire\Component;

class EditAvatarModal extends Component
{
    use WithFileUploads;

    public null|string|array|UploadedFile $avatar;

    public function render(): Factory|View|Application
    {
        return view('livewire.profile.edit-avatar-modal');
    }
}
