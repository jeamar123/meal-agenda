<?php

namespace App\Modules\HouseholdMember\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HouseholdMember\Actions\CreateHouseholdMemberAction;
use App\Modules\HouseholdMember\Http\Requests\CreateHouseholdMemberRequest;
use App\Modules\HouseholdMember\Http\Resources\HouseholdMemberResource;

class CreateHouseholdMemberController extends Controller
{
    public function __invoke(CreateHouseholdMemberRequest $request, CreateHouseholdMemberAction $action)
    {
        $householdMember = $action->execute($request->validated());

        return new HouseholdMemberResource($householdMember);
    }
}
