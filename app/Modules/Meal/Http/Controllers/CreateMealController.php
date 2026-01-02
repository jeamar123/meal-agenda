<?php

namespace App\Modules\Meal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Meal\Actions\CreateMealAction;
use App\Modules\Meal\Http\Requests\CreateMealRequest;
use App\Modules\Meal\Http\Resources\MealResource;
use Illuminate\Http\RedirectResponse;

class CreateMealController extends Controller
{
    public function __invoke(
        CreateMealRequest $request,
        CreateMealAction $action
    ): RedirectResponse
    {
        $action->execute($request->validated());

        return success_response(route: route('meal.index', $request->query()));
    }
}
