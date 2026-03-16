<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TeacherPosition;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPositionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TeacherPosition');
    }

    public function view(AuthUser $authUser, TeacherPosition $teacherPosition): bool
    {
        return $authUser->can('View:TeacherPosition');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TeacherPosition');
    }

    public function update(AuthUser $authUser, TeacherPosition $teacherPosition): bool
    {
        return $authUser->can('Update:TeacherPosition');
    }

    public function delete(AuthUser $authUser, TeacherPosition $teacherPosition): bool
    {
        return $authUser->can('Delete:TeacherPosition');
    }

    public function restore(AuthUser $authUser, TeacherPosition $teacherPosition): bool
    {
        return $authUser->can('Restore:TeacherPosition');
    }

    public function forceDelete(AuthUser $authUser, TeacherPosition $teacherPosition): bool
    {
        return $authUser->can('ForceDelete:TeacherPosition');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TeacherPosition');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TeacherPosition');
    }

    public function replicate(AuthUser $authUser, TeacherPosition $teacherPosition): bool
    {
        return $authUser->can('Replicate:TeacherPosition');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TeacherPosition');
    }

}