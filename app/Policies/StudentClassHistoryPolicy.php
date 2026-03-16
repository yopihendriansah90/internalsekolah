<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\StudentClassHistory;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentClassHistoryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:StudentClassHistory');
    }

    public function view(AuthUser $authUser, StudentClassHistory $studentClassHistory): bool
    {
        return $authUser->can('View:StudentClassHistory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:StudentClassHistory');
    }

    public function update(AuthUser $authUser, StudentClassHistory $studentClassHistory): bool
    {
        return $authUser->can('Update:StudentClassHistory');
    }

    public function delete(AuthUser $authUser, StudentClassHistory $studentClassHistory): bool
    {
        return $authUser->can('Delete:StudentClassHistory');
    }

    public function restore(AuthUser $authUser, StudentClassHistory $studentClassHistory): bool
    {
        return $authUser->can('Restore:StudentClassHistory');
    }

    public function forceDelete(AuthUser $authUser, StudentClassHistory $studentClassHistory): bool
    {
        return $authUser->can('ForceDelete:StudentClassHistory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:StudentClassHistory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:StudentClassHistory');
    }

    public function replicate(AuthUser $authUser, StudentClassHistory $studentClassHistory): bool
    {
        return $authUser->can('Replicate:StudentClassHistory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:StudentClassHistory');
    }

}