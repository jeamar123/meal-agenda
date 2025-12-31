<?php

namespace App\Modules\HouseholdMember\Actions;

use App\Modules\HouseholdMember\Models\HouseholdMember;

class UpdateHouseholdMemberAction
{
    public function execute(HouseholdMember $householdMember, array $data): HouseholdMember
    {
        $householdMember->update($data);
        return $householdMember->fresh();
    }
}
