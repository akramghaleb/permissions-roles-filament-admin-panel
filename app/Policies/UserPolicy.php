<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'viewAny: User')
            ->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'view: User')
            ->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'create: User')
            ->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'update: User')
            ->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'delete: User')
            ->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'restore: User')
            ->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'forceDelete: User')
            ->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }
}
