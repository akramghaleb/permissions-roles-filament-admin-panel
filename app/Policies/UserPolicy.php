<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'read: user')->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }


    public function create(User $user)
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'create: user')->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    public function update(User $user, User $model)
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'update: user')->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    public function delete(User $user, User $model)
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'delete: user')->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }
}
