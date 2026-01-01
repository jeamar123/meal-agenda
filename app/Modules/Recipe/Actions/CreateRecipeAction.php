<?php

namespace App\Modules\Recipe\Actions;

use App\Modules\Recipe\Models\Recipe;

class CreateRecipeAction
{
    public function execute(array $data): Recipe
    {
        $data['user_id'] = auth()->id();

        return Recipe::create($data);
    }
}
