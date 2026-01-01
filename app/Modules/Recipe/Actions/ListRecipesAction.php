<?php

namespace App\Modules\Recipe\Actions;

use App\Modules\Recipe\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;

class ListRecipesAction
{
    public function execute(?string $category = null): Collection
    {
        $query = Recipe::query()
            ->forUser(auth()->id())
            ->orderedByName();

        if ($category) {
            $query->byCategory($category);
        }

        return $query->get();
    }
}
