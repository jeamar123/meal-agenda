<?php

namespace App\Modules\Recipe\Actions;

use App\Modules\Recipe\Models\Recipe;

class GetRecipeAction
{
    public function execute(Recipe $recipe): Recipe
    {
        return $recipe->load('user');
    }
}
