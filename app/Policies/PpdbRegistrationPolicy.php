<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PpdbRegistration;
use Illuminate\Auth\Access\HandlesAuthorization;

class PpdbRegistrationPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PpdbRegistration');
    }

    public function view(AuthUser $authUser, PpdbRegistration $ppdbRegistration): bool
    {
        return $authUser->can('View:PpdbRegistration');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PpdbRegistration');
    }

    public function update(AuthUser $authUser, PpdbRegistration $ppdbRegistration): bool
    {
        return $authUser->can('Update:PpdbRegistration');
    }

    public function delete(AuthUser $authUser, PpdbRegistration $ppdbRegistration): bool
    {
        return $authUser->can('Delete:PpdbRegistration');
    }

    public function restore(AuthUser $authUser, PpdbRegistration $ppdbRegistration): bool
    {
        return $authUser->can('Restore:PpdbRegistration');
    }

    public function forceDelete(AuthUser $authUser, PpdbRegistration $ppdbRegistration): bool
    {
        return $authUser->can('ForceDelete:PpdbRegistration');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PpdbRegistration');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PpdbRegistration');
    }

    public function replicate(AuthUser $authUser, PpdbRegistration $ppdbRegistration): bool
    {
        return $authUser->can('Replicate:PpdbRegistration');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PpdbRegistration');
    }

}