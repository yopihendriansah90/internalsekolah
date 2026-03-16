<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AdditionalAssignment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdditionalAssignmentPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AdditionalAssignment');
    }

    public function view(AuthUser $authUser, AdditionalAssignment $additionalAssignment): bool
    {
        return $authUser->can('View:AdditionalAssignment');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AdditionalAssignment');
    }

    public function update(AuthUser $authUser, AdditionalAssignment $additionalAssignment): bool
    {
        return $authUser->can('Update:AdditionalAssignment');
    }

    public function delete(AuthUser $authUser, AdditionalAssignment $additionalAssignment): bool
    {
        return $authUser->can('Delete:AdditionalAssignment');
    }

    public function restore(AuthUser $authUser, AdditionalAssignment $additionalAssignment): bool
    {
        return $authUser->can('Restore:AdditionalAssignment');
    }

    public function forceDelete(AuthUser $authUser, AdditionalAssignment $additionalAssignment): bool
    {
        return $authUser->can('ForceDelete:AdditionalAssignment');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AdditionalAssignment');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AdditionalAssignment');
    }

    public function replicate(AuthUser $authUser, AdditionalAssignment $additionalAssignment): bool
    {
        return $authUser->can('Replicate:AdditionalAssignment');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AdditionalAssignment');
    }

}