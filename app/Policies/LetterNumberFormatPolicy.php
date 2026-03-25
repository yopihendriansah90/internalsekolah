<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\LetterNumberFormat;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class LetterNumberFormatPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LetterNumberFormat');
    }

    public function view(AuthUser $authUser, LetterNumberFormat $letterNumberFormat): bool
    {
        return $authUser->can('View:LetterNumberFormat');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LetterNumberFormat');
    }

    public function update(AuthUser $authUser, LetterNumberFormat $letterNumberFormat): bool
    {
        return $authUser->can('Update:LetterNumberFormat');
    }

    public function delete(AuthUser $authUser, LetterNumberFormat $letterNumberFormat): bool
    {
        return $authUser->can('Delete:LetterNumberFormat');
    }

    public function restore(AuthUser $authUser, LetterNumberFormat $letterNumberFormat): bool
    {
        return $authUser->can('Restore:LetterNumberFormat');
    }

    public function forceDelete(AuthUser $authUser, LetterNumberFormat $letterNumberFormat): bool
    {
        return $authUser->can('ForceDelete:LetterNumberFormat');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:LetterNumberFormat');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:LetterNumberFormat');
    }

    public function replicate(AuthUser $authUser, LetterNumberFormat $letterNumberFormat): bool
    {
        return $authUser->can('Replicate:LetterNumberFormat');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:LetterNumberFormat');
    }
}
