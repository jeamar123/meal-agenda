<?php

namespace App\Modules\Meal\Actions;

use App\Modules\Meal\Models\Meal;
use Illuminate\Support\Collection;

class ListMealsByDateAction
{
    public function execute(string $userId, string $date): Collection
    {
        return Meal::with('assignedTo')
            ->forUser($userId)
            ->forDate($date)
            ->orderedByTime()
            ->get();
    }
}
