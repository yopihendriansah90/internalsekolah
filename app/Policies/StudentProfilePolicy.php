<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\StudentProfile;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentProfilePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:StudentProfile');
    }

    public function view(AuthUser $authUser, StudentProfile $studentProfile): bool
    {
        return $authUser->can('View:StudentProfile');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:StudentProfile');
    }

    public function update(AuthUser $authUser, StudentProfile $studentProfile): bool
    {
        return $authUser->can('Update:StudentProfile');
    }

    public function delete(AuthUser $authUser, StudentProfile $studentProfile): bool
    {
        return $authUser->can('Delete:StudentProfile');
    }

    public function restore(AuthUser $authUser, StudentProfile $studentProfile): bool
    {
        return $authUser->can('Restore:StudentProfile');
    }

    public function forceDelete(AuthUser $authUser, StudentProfile $studentProfile): bool
    {
        return $authUser->can('ForceDelete:StudentProfile');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:StudentProfile');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:StudentProfile');
    }

    public function replicate(AuthUser $authUser, StudentProfile $studentProfile): bool
    {
        return $authUser->can('Replicate:StudentProfile');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:StudentProfile');
    }

}