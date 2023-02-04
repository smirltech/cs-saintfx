<?php

namespace App\Policies;

use App\Models\Cours;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Cours $cours)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Cours $cours)
    {
        //
    }

    public function delete(User $user, Cours $cours)
    {
        //
    }

    public function restore(User $user, Cours $cours)
    {
        //
    }

    public function forceDelete(User $user, Cours $cours)
    {
        //
    }
}
