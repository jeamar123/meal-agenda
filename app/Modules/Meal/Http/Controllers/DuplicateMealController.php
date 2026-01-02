<?php

namespace App\Modules\Meal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Meal\Actions\DuplicateMealAction;
use App\Modules\Meal\Models\Meal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DuplicateMealController extends Controller
{
    public function __invoke(
        Request $request,
        Meal $meal,
        DuplicateMealAction $action
    ): RedirectResponse
    {
        $this->authorize('duplicate', $meal);

        $action->execute($meal);

        return success_response(route: route('meal.index', $request->query()));
    }
}
