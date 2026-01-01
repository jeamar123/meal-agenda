<?php

namespace App\Modules\Recipe\Policies;

use App\Modules\Recipe\Models\Recipe;
use App\Modules\User\Models\User;

class RecipePolicy
{
    /**
     * Determine if the user can update the recipe.
     */
    public function update(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id;
    }

    /**
     * Determine if the user can delete the recipe.
     */
    public function delete(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id;
    }
}
