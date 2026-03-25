<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\LetterSignatory;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class LetterSignatoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LetterSignatory');
    }

    public function view(AuthUser $authUser, LetterSignatory $letterSignatory): bool
    {
        return $authUser->can('View:LetterSignatory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LetterSignatory');
    }

    public function update(AuthUser $authUser, LetterSignatory $letterSignatory): bool
    {
        return $authUser->can('Update:LetterSignatory');
    }

    public function delete(AuthUser $authUser, LetterSignatory $letterSignatory): bool
    {
        return $authUser->can('Delete:LetterSignatory');
    }

    public function restore(AuthUser $authUser, LetterSignatory $letterSignatory): bool
    {
        return $authUser->can('Restore:LetterSignatory');
    }

    public function forceDelete(AuthUser $authUser, LetterSignatory $letterSignatory): bool
    {
        return $authUser->can('ForceDelete:LetterSignatory');
    }
}
