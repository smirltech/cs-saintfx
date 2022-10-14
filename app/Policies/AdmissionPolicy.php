<?php

namespace App\Policies;

use App\Models\Inscription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdmissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Inscription $admission)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Inscription $admission)
    {
        //
    }

    public function delete(User $user, Inscription $admission)
    {
        //
    }

    public function restore(User $user, Inscription $admission)
    {
        //
    }

    public function forceDelete(User $user, Inscription $admission)
    {
        //
    }
}
