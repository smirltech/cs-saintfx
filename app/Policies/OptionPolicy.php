<?php

namespace App\Policies;

use App\Models\Option;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Option $option)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Option $option)
    {
        //
    }

    public function delete(User $user, Option $option)
    {
        //
    }

    public function restore(User $user, Option $option)
    {
        //
    }

    public function forceDelete(User $user, Option $option)
    {
        //
    }
}
