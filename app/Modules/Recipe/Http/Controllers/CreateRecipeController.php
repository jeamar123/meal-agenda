<?php

namespace App\Modules\Recipe\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recipe\Actions\CreateRecipeAction;
use App\Modules\Recipe\Http\Requests\CreateRecipeRequest;
use Illuminate\Http\RedirectResponse;

class CreateRecipeController extends Controller
{
    public function __invoke(
        CreateRecipeRequest $request,
        CreateRecipeAction $action
    ): RedirectResponse
    {
        $action->execute($request->validated());

        return success_response(route: route('recipes.index', $request->query()));
    }
}
