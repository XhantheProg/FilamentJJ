<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Ejercicio;
use Illuminate\Auth\Access\HandlesAuthorization;

class EjercicioPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Ejercicio');
    }

    public function view(AuthUser $authUser, Ejercicio $ejercicio): bool
    {
        return $authUser->can('View:Ejercicio');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Ejercicio');
    }

    public function update(AuthUser $authUser, Ejercicio $ejercicio): bool
    {
        return $authUser->can('Update:Ejercicio');
    }

    public function delete(AuthUser $authUser, Ejercicio $ejercicio): bool
    {
        return $authUser->can('Delete:Ejercicio');
    }

    public function restore(AuthUser $authUser, Ejercicio $ejercicio): bool
    {
        return $authUser->can('Restore:Ejercicio');
    }

    public function forceDelete(AuthUser $authUser, Ejercicio $ejercicio): bool
    {
        return $authUser->can('ForceDelete:Ejercicio');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Ejercicio');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Ejercicio');
    }

    public function replicate(AuthUser $authUser, Ejercicio $ejercicio): bool
    {
        return $authUser->can('Replicate:Ejercicio');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Ejercicio');
    }

}