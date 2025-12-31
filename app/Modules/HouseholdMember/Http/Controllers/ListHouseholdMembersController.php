<?php

namespace App\Modules\HouseholdMember\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HouseholdMember\Actions\ListHouseholdMembersAction;
use App\Modules\HouseholdMember\Http\Resources\HouseholdMemberResource;
use Illuminate\Support\Facades\Auth;

class ListHouseholdMembersController extends Controller
{
    public function __invoke(ListHouseholdMembersAction $action)
    {
        $householdMembers = $action->execute(Auth::id());

        return HouseholdMemberResource::collection($householdMembers);
    }
}
