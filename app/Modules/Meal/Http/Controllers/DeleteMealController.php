<?php

namespace App\Modules\Meal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Meal\Actions\DeleteMealAction;
use App\Modules\Meal\Models\Meal;

class DeleteMealController extends Controller
{
    public function __invoke(Meal $meal, DeleteMealAction $action)
    {
        $this->authorize('delete', $meal);

        $action->execute($meal);

        return response()->json(['message' => 'Meal deleted successfully'], 200);
    }
}
