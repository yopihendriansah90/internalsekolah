<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SubjectTeacher;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectTeacherPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SubjectTeacher');
    }

    public function view(AuthUser $authUser, SubjectTeacher $subjectTeacher): bool
    {
        return $authUser->can('View:SubjectTeacher');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SubjectTeacher');
    }

    public function update(AuthUser $authUser, SubjectTeacher $subjectTeacher): bool
    {
        return $authUser->can('Update:SubjectTeacher');
    }

    public function delete(AuthUser $authUser, SubjectTeacher $subjectTeacher): bool
    {
        return $authUser->can('Delete:SubjectTeacher');
    }

    public function restore(AuthUser $authUser, SubjectTeacher $subjectTeacher): bool
    {
        return $authUser->can('Restore:SubjectTeacher');
    }

    public function forceDelete(AuthUser $authUser, SubjectTeacher $subjectTeacher): bool
    {
        return $authUser->can('ForceDelete:SubjectTeacher');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SubjectTeacher');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SubjectTeacher');
    }

    public function replicate(AuthUser $authUser, SubjectTeacher $subjectTeacher): bool
    {
        return $authUser->can('Replicate:SubjectTeacher');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SubjectTeacher');
    }

}