<?php

namespace App\Modules\HouseholdMember\Policies;

use App\Modules\User\Models\User;
use App\Modules\HouseholdMember\Models\HouseholdMember;

class HouseholdMemberPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, HouseholdMember $householdMember): bool
    {
        return $user->id === $householdMember->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, HouseholdMember $householdMember): bool
    {
        return $user->id === $householdMember->user_id;
    }

    public function delete(User $user, HouseholdMember $householdMember): bool
    {
        return $user->id === $householdMember->user_id;
    }
}
