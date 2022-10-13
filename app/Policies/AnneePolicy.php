<?php

namespace App\Policies;

use App\Models\Annee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnneePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Annee $annee)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Annee $annee)
    {
        //
    }

    public function delete(User $user, Annee $annee)
    {
        //
    }

    public function restore(User $user, Annee $annee)
    {
        //
    }

    public function forceDelete(User $user, Annee $annee)
    {
        //
    }
}
