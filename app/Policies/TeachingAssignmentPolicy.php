<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TeachingAssignment;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeachingAssignmentPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TeachingAssignment');
    }

    public function view(AuthUser $authUser, TeachingAssignment $teachingAssignment): bool
    {
        return $authUser->can('View:TeachingAssignment');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TeachingAssignment');
    }

    public function update(AuthUser $authUser, TeachingAssignment $teachingAssignment): bool
    {
        return $authUser->can('Update:TeachingAssignment');
    }

    public function delete(AuthUser $authUser, TeachingAssignment $teachingAssignment): bool
    {
        return $authUser->can('Delete:TeachingAssignment');
    }

    public function restore(AuthUser $authUser, TeachingAssignment $teachingAssignment): bool
    {
        return $authUser->can('Restore:TeachingAssignment');
    }

    public function forceDelete(AuthUser $authUser, TeachingAssignment $teachingAssignment): bool
    {
        return $authUser->can('ForceDelete:TeachingAssignment');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TeachingAssignment');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TeachingAssignment');
    }

    public function replicate(AuthUser $authUser, TeachingAssignment $teachingAssignment): bool
    {
        return $authUser->can('Replicate:TeachingAssignment');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TeachingAssignment');
    }

}