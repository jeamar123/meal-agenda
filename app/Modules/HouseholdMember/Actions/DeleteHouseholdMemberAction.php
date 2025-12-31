<?php

namespace App\Modules\HouseholdMember\Actions;

use App\Modules\HouseholdMember\Models\HouseholdMember;

class DeleteHouseholdMemberAction
{
    public function execute(HouseholdMember $householdMember): bool
    {
        return $householdMember->delete();
    }
}
