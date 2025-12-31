<?php

namespace App\Modules\HouseholdMember\Actions;

use App\Modules\HouseholdMember\Models\HouseholdMember;

class CreateHouseholdMemberAction
{
    public function execute(array $data): HouseholdMember
    {
        return HouseholdMember::create($data);
    }
}
