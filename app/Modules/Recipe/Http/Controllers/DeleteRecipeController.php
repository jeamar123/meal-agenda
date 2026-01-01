<?php

namespace App\Modules\Recipe\Http\Controllers;

use App\Modules\Recipe\Actions\DeleteRecipeAction;
use App\Modules\Recipe\Models\Recipe;

class DeleteRecipeController
{
    public function __invoke(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);

        app(DeleteRecipeAction::class)->execute($recipe);

        return response()->json(['message' => 'Recipe deleted successfully']);
    }

    protected function authorize($ability, $recipe)
    {
        if (!auth()->user()->can($ability, $recipe)) {
            abort(403);
        }
    }
}
