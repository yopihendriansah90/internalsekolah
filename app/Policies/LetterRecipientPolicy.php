<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\LetterRecipient;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class LetterRecipientPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LetterRecipient');
    }

    public function view(AuthUser $authUser, LetterRecipient $letterRecipient): bool
    {
        return $authUser->can('View:LetterRecipient');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LetterRecipient');
    }

    public function update(AuthUser $authUser, LetterRecipient $letterRecipient): bool
    {
        return $authUser->can('Update:LetterRecipient');
    }

    public function delete(AuthUser $authUser, LetterRecipient $letterRecipient): bool
    {
        return $authUser->can('Delete:LetterRecipient');
    }

    public function restore(AuthUser $authUser, LetterRecipient $letterRecipient): bool
    {
        return $authUser->can('Restore:LetterRecipient');
    }

    public function forceDelete(AuthUser $authUser, LetterRecipient $letterRecipient): bool
    {
        return $authUser->can('ForceDelete:LetterRecipient');
    }
}
