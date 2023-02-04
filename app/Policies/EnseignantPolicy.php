<?php

namespace App\Policies;

use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnseignantPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Enseignant $enseignant)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Enseignant $enseignant)
    {
        //
    }

    public function delete(User $user, Enseignant $enseignant)
    {
        //
    }

    public function restore(User $user, Enseignant $enseignant)
    {
        //
    }

    public function forceDelete(User $user, Enseignant $enseignant)
    {
        //
    }
}
