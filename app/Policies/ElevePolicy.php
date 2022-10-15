<?php

namespace App\Policies;

use App\Models\Eleve;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ElevePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Eleve $eleve)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Eleve $eleve)
    {
        //
    }

    public function delete(User $user, Eleve $eleve)
    {
        //
    }

    public function restore(User $user, Eleve $eleve)
    {
        //
    }

    public function forceDelete(User $user, Eleve $eleve)
    {
        //
    }
}
