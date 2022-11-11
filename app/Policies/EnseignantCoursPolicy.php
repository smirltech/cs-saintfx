<?php

namespace App\Policies;

use App\Models\EnseignantCours;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnseignantCoursPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, EnseignantCours $enseignantCours)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, EnseignantCours $enseignantCours)
    {
        //
    }

    public function delete(User $user, EnseignantCours $enseignantCours)
    {
        //
    }

    public function restore(User $user, EnseignantCours $enseignantCours)
    {
        //
    }

    public function forceDelete(User $user, EnseignantCours $enseignantCours)
    {
        //
    }
}
