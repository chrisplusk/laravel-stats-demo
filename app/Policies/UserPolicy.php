<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function view(User $user, User $model)
    {
        return $model->public || $user->id === $model->id;
    }

    public function create(User $user)
    {
        return $user->admin;
    }

    public function update(User $user, User $model)
    {
        return ($user->admin && $model->public) || $user->id === $model->id;
    }

    public function delete(User $user, User $model)
    {
        return ($user->admin && $model->public) || $user->id === $model->id;
    }
}
