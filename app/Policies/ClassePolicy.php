<?php

namespace App\Policies;

use App\Models\Classe;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Classe $classe)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Classe $classe)
    {
        //
    }

    public function delete(User $user, Classe $classe)
    {
        //
    }

    public function restore(User $user, Classe $classe)
    {
        //
    }

    public function forceDelete(User $user, Classe $classe)
    {
        //
    }
}
