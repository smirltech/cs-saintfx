<?php

namespace App\Policies;

use App\Models\Inscription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InscriptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Inscription $inscription)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Inscription $inscription)
    {
        //
    }

    public function delete(User $user, Inscription $inscription)
    {
        //
    }

    public function restore(User $user, Inscription $inscription)
    {
        //
    }

    public function forceDelete(User $user, Inscription $inscription)
    {
        //
    }
}
