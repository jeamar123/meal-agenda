<?php

namespace App\Modules\Meal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Meal\Actions\UpdateMealAction;
use App\Modules\Meal\Http\Requests\UpdateMealRequest;
use App\Modules\Meal\Models\Meal;
use Illuminate\Http\RedirectResponse;

class UpdateMealController extends Controller
{
    public function __invoke(
        UpdateMealRequest $request,
        Meal $meal,
        UpdateMealAction $action
    ): RedirectResponse
    {
        $action->execute($meal, $request->validated());

        return success_response(route: route('meal.index', $request->query()));
    }
}
