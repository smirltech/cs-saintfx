<?php

namespace App\Policies;

use App\Models\Filiere;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilierePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Filiere $filiere)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Filiere $filiere)
    {
        //
    }

    public function delete(User $user, Filiere $filiere)
    {
        //
    }

    public function restore(User $user, Filiere $filiere)
    {
        //
    }

    public function forceDelete(User $user, Filiere $filiere)
    {
        //
    }
}
