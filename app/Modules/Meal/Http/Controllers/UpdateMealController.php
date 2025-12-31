<?php

namespace App\Modules\Meal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Meal\Actions\UpdateMealAction;
use App\Modules\Meal\Http\Requests\UpdateMealRequest;
use App\Modules\Meal\Http\Resources\MealResource;
use App\Modules\Meal\Models\Meal;

class UpdateMealController extends Controller
{
    public function __invoke(UpdateMealRequest $request, Meal $meal, UpdateMealAction $action)
    {
        $meal = $action->execute($meal, $request->validated());

        return new MealResource($meal);
    }
}
