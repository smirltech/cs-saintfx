<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Section $section)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Section $section)
    {
        //
    }

    public function delete(User $user, Section $section)
    {
        //
    }

    public function restore(User $user, Section $section)
    {
        //
    }

    public function forceDelete(User $user, Section $section)
    {
        //
    }
}
