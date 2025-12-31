<?php

namespace App\Modules\Meal\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Modules\HouseholdMember\Actions\ListHouseholdMembersAction;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomePage extends Controller
{
    public function __invoke(ListHouseholdMembersAction $action)
    {
        $householdMembers = $action->execute(Auth::id());

        return Inertia::render('Home', [
            'householdMembers' => $householdMembers,
        ]);
    }
}
