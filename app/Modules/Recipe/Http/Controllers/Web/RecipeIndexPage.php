<?php

namespace App\Modules\Recipe\Http\Controllers\Web;

use App\Modules\Recipe\Actions\ListRecipesAction;
use App\Modules\Recipe\Http\Resources\RecipeResource;
use Inertia\Inertia;
use Inertia\Response;

class RecipeIndexPage
{
    public function __invoke(
        ListRecipesAction $listRecipeAction
    ): Response
    {
        $recipes = $listRecipeAction->execute();

        return Inertia::render('Recipe/Index', [
            'recipes' => RecipeResource::collection($recipes),
        ]);
    }
}
