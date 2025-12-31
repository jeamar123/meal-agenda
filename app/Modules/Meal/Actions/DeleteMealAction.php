<?php

namespace App\Modules\Meal\Actions;

use App\Modules\Meal\Models\Meal;

class DeleteMealAction
{
    public function execute(Meal $meal): bool
    {
        return $meal->delete();
    }
}
