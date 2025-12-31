<?php

namespace App\Modules\HouseholdMember\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HouseholdMember\Actions\DeleteHouseholdMemberAction;
use App\Modules\HouseholdMember\Models\HouseholdMember;

class DeleteHouseholdMemberController extends Controller
{
    public function __invoke(HouseholdMember $householdMember, DeleteHouseholdMemberAction $action)
    {
        $this->authorize('delete', $householdMember);

        $action->execute($householdMember);

        return response()->json(['message' => 'Household member deleted successfully'], 200);
    }
}
