<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\IncomingLetterDisposition;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class IncomingLetterDispositionPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:IncomingLetterDisposition');
    }

    public function view(AuthUser $authUser, IncomingLetterDisposition $incomingLetterDisposition): bool
    {
        return $authUser->can('View:IncomingLetterDisposition');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:IncomingLetterDisposition');
    }

    public function update(AuthUser $authUser, IncomingLetterDisposition $incomingLetterDisposition): bool
    {
        return $authUser->can('Update:IncomingLetterDisposition');
    }

    public function delete(AuthUser $authUser, IncomingLetterDisposition $incomingLetterDisposition): bool
    {
        return $authUser->can('Delete:IncomingLetterDisposition');
    }

    public function restore(AuthUser $authUser, IncomingLetterDisposition $incomingLetterDisposition): bool
    {
        return $authUser->can('Restore:IncomingLetterDisposition');
    }

    public function forceDelete(AuthUser $authUser, IncomingLetterDisposition $incomingLetterDisposition): bool
    {
        return $authUser->can('ForceDelete:IncomingLetterDisposition');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:IncomingLetterDisposition');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:IncomingLetterDisposition');
    }

    public function replicate(AuthUser $authUser, IncomingLetterDisposition $incomingLetterDisposition): bool
    {
        return $authUser->can('Replicate:IncomingLetterDisposition');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:IncomingLetterDisposition');
    }
}
