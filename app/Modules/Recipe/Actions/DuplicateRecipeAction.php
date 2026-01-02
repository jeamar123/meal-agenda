<?php

namespace App\Modules\Recipe\Actions;

use App\Modules\Recipe\Models\Recipe;

class DuplicateRecipeAction
{
    public function execute(Recipe $recipe): Recipe
    {
        $duplicated = $recipe->replicate();
        $duplicated->save();

        return $duplicated;
    }
}
