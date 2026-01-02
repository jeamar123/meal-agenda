<?php

namespace App\Modules\Meal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Meal\Actions\DeleteMealAction;
use App\Modules\Meal\Models\Meal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeleteMealController extends Controller
{
    public function __invoke(
        Request $request,
        Meal $meal,
        DeleteMealAction $action
    ): RedirectResponse
    {
        $this->authorize('delete', $meal);

        $action->execute($meal);

        return success_response(route: route('meal.index', $request->query()));
    }
}
