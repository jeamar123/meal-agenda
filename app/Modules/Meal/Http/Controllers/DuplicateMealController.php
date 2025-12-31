<?php

namespace App\Modules\Meal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Meal\Actions\DuplicateMealAction;
use App\Modules\Meal\Http\Resources\MealResource;
use App\Modules\Meal\Models\Meal;

class DuplicateMealController extends Controller
{
    public function __invoke(Meal $meal, DuplicateMealAction $action)
    {
        $this->authorize('duplicate', $meal);

        $duplicated = $action->execute($meal);

        return new MealResource($duplicated);
    }
}
