<?php

namespace App\Modules\Recipe\Actions;

use App\Modules\Recipe\Models\Recipe;

class UpdateRecipeAction
{
    public function execute(Recipe $recipe, array $data): Recipe
    {
        $recipe->update($data);

        return $recipe->fresh();
    }
}
