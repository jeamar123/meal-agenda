<?php

namespace App\Modules\HouseholdMember\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HouseholdMember\Actions\UpdateHouseholdMemberAction;
use App\Modules\HouseholdMember\Http\Requests\UpdateHouseholdMemberRequest;
use App\Modules\HouseholdMember\Http\Resources\HouseholdMemberResource;
use App\Modules\HouseholdMember\Models\HouseholdMember;

class UpdateHouseholdMemberController extends Controller
{
    public function __invoke(UpdateHouseholdMemberRequest $request, HouseholdMember $householdMember, UpdateHouseholdMemberAction $action)
    {
        $householdMember = $action->execute($householdMember, $request->validated());

        return new HouseholdMemberResource($householdMember);
    }
}
