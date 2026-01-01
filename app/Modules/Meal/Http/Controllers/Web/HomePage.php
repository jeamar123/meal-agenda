<?php

namespace App\Modules\Meal\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Modules\HouseholdMember\Actions\ListHouseholdMembersAction;
use App\Modules\Recipe\Actions\ListRecipesAction;
use App\Modules\Recipe\Http\Resources\RecipeResource;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomePage extends Controller
{
    public function __invoke(
        ListHouseholdMembersAction $householdMembersAction,
        ListRecipesAction $recipesAction
    ) {
        $householdMembers = $householdMembersAction->execute(Auth::id());
        $recipes = $recipesAction->execute();

        return Inertia::render('Home', [
            'householdMembers' => $householdMembers,
            'recipes' => RecipeResource::collection($recipes),
        ]);
    }
}
