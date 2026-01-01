<?php

namespace App\Modules\Recipe\Actions;

use App\Modules\Recipe\Models\Recipe;

class DeleteRecipeAction
{
    public function execute(Recipe $recipe): bool
    {
        return $recipe->delete();
    }
}
