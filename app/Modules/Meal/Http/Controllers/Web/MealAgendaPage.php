<?php

declare(strict_types=1);

namespace App\Modules\Meal\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Modules\Meal\Actions\ListMealsByDateAction;
use App\Modules\Meal\Http\Resources\MealResource;
use App\Modules\HouseholdMember\Actions\ListHouseholdMembersAction;
use App\Modules\Recipe\Actions\ListRecipesAction;
use App\Modules\Recipe\Http\Resources\RecipeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class MealAgendaPage extends Controller
{
    public function __invoke(
        Request $request,
        ListMealsByDateAction $listMealsAction,
        ListHouseholdMembersAction $householdMembersAction,
        ListRecipesAction $recipesAction,
    ): Response {
        $user = Auth::id();
        $date = $request->query('date', now()->toDateString());

        $meals = $listMealsAction->execute($user, $date);
        $members = $householdMembersAction->execute($user);
        $recipes = $recipesAction->execute();

        return Inertia::render('Home', [
            'meals' => MealResource::collection($meals),
            'members' => $members,
            'recipes' => RecipeResource::collection($recipes),
        ]);
    }
}
  