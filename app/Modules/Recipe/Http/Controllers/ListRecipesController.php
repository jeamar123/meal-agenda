<?php

namespace App\Modules\Recipe\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recipe\Actions\ListRecipesAction;
use App\Modules\Recipe\Http\Resources\RecipeResource;
use Illuminate\Http\Request;

class ListRecipesController extends Controller
{
    public function __invoke(Request $request)
    {
        $recipes = app(ListRecipesAction::class)->execute(
            $request->input('category')
        );

        return RecipeResource::collection($recipes);
    }
}
