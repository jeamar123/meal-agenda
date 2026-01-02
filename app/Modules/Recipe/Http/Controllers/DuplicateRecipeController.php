<?php

namespace App\Modules\Recipe\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recipe\Actions\DuplicateRecipeAction;
use App\Modules\Recipe\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DuplicateRecipeController extends Controller
{
    public function __invoke(
        Request $request,
        Recipe $recipe,
        DuplicateRecipeAction $action
    ): RedirectResponse
    {
        $this->authorize('duplicate', $recipe);

        $action->execute($recipe);

        return success_response(route: route('recipes.index', $request->query()));
    }
}
