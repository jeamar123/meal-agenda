<?php

namespace App\Modules\Recipe\Http\Controllers;

use App\Modules\Recipe\Actions\CreateRecipeAction;
use App\Modules\Recipe\Http\Requests\CreateRecipeRequest;
use App\Modules\Recipe\Http\Resources\RecipeResource;

class CreateRecipeController
{
    public function __invoke(CreateRecipeRequest $request)
    {
        $recipe = app(CreateRecipeAction::class)->execute(
            $request->validated()
        );

        return new RecipeResource($recipe);
    }
}
