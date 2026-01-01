<?php

namespace App\Modules\Recipe\Http\Controllers;

use App\Modules\Recipe\Actions\UpdateRecipeAction;
use App\Modules\Recipe\Http\Requests\UpdateRecipeRequest;
use App\Modules\Recipe\Http\Resources\RecipeResource;
use App\Modules\Recipe\Models\Recipe;

class UpdateRecipeController
{
    public function __invoke(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $recipe = app(UpdateRecipeAction::class)->execute(
            $recipe,
            $request->validated()
        );

        return new RecipeResource($recipe);
    }
}
