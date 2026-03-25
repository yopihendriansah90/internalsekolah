<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\LetterLog;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class LetterLogPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LetterLog');
    }

    public function view(AuthUser $authUser, LetterLog $letterLog): bool
    {
        return $authUser->can('View:LetterLog');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LetterLog');
    }

    public function update(AuthUser $authUser, LetterLog $letterLog): bool
    {
        return $authUser->can('Update:LetterLog');
    }

    public function delete(AuthUser $authUser, LetterLog $letterLog): bool
    {
        return $authUser->can('Delete:LetterLog');
    }

    public function restore(AuthUser $authUser, LetterLog $letterLog): bool
    {
        return $authUser->can('Restore:LetterLog');
    }

    public function forceDelete(AuthUser $authUser, LetterLog $letterLog): bool
    {
        return $authUser->can('ForceDelete:LetterLog');
    }
}
