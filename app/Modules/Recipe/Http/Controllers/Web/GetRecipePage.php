<?php

namespace App\Modules\Recipe\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Modules\Recipe\Actions\GetRecipeAction;
use App\Modules\Recipe\Http\Resources\RecipeResource;
use App\Modules\Recipe\Models\Recipe;
use Inertia\Inertia;
use Inertia\Response;

class GetRecipePage extends Controller
{
    public function __invoke(
        Recipe $recipe,
        GetRecipeAction $action
    ): Response
    {
        $this->authorize('view', $recipe);

        $recipeData = $action->execute($recipe);

        return Inertia::render('Recipe/Show', [
            'recipe' => new RecipeResource($recipeData),
        ]);
    }
}
