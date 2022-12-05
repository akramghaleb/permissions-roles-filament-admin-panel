<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'moderator' ]);
    }


    public function create(User $user)
    {
        return $user->hasAnyRole(['super-admin', 'admin' ]);
    }

    public function update(User $user, User $model)
    {
        return $user->hasAnyRole(['super-admin', 'admin' ]);
    }

    public function delete(User $user, User $model)
    {
        return $user->hasAnyRole(['super-admin', 'admin' ]);
    }

    public function restore(User $user, User $model)
    {
        return $user->hasAnyRole(['super-admin', 'admin' ]);
    }
}
