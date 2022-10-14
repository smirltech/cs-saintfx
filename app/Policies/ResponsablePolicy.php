<?php

namespace App\Policies;

use App\Models\Responsable;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResponsablePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Responsable $responsable)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Responsable $responsable)
    {
        //
    }

    public function delete(User $user, Responsable $responsable)
    {
        //
    }

    public function restore(User $user, Responsable $responsable)
    {
        //
    }

    public function forceDelete(User $user, Responsable $responsable)
    {
        //
    }
}
