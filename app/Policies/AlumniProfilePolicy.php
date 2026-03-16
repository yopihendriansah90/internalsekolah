<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AlumniProfile;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlumniProfilePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AlumniProfile');
    }

    public function view(AuthUser $authUser, AlumniProfile $alumniProfile): bool
    {
        return $authUser->can('View:AlumniProfile');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AlumniProfile');
    }

    public function update(AuthUser $authUser, AlumniProfile $alumniProfile): bool
    {
        return $authUser->can('Update:AlumniProfile');
    }

    public function delete(AuthUser $authUser, AlumniProfile $alumniProfile): bool
    {
        return $authUser->can('Delete:AlumniProfile');
    }

    public function restore(AuthUser $authUser, AlumniProfile $alumniProfile): bool
    {
        return $authUser->can('Restore:AlumniProfile');
    }

    public function forceDelete(AuthUser $authUser, AlumniProfile $alumniProfile): bool
    {
        return $authUser->can('ForceDelete:AlumniProfile');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AlumniProfile');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AlumniProfile');
    }

    public function replicate(AuthUser $authUser, AlumniProfile $alumniProfile): bool
    {
        return $authUser->can('Replicate:AlumniProfile');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AlumniProfile');
    }

}