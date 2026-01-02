<?php

namespace App\Modules\Recipe\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recipe\Actions\DeleteRecipeAction;
use App\Modules\Recipe\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeleteRecipeController extends Controller
{
    public function __invoke(
        Request $request,
        Recipe $recipe,
        DeleteRecipeAction $action
    ): RedirectResponse
    {
        $this->authorize('delete', $recipe);

        $action->execute($recipe);

        return success_response(route: route('recipes.index', $request->query()));
    }
}
