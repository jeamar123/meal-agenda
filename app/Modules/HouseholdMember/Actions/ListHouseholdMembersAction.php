<?php

namespace App\Modules\HouseholdMember\Actions;

use App\Modules\HouseholdMember\Models\HouseholdMember;
use Illuminate\Support\Collection;

class ListHouseholdMembersAction
{
    public function execute(string $userId): Collection
    {
        return HouseholdMember::forUser($userId)
            ->ordered()
            ->get();
    }
}
