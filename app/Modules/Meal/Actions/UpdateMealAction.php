<?php

namespace App\Modules\Meal\Actions;

use App\Modules\Meal\Models\Meal;

class UpdateMealAction
{
    public function execute(Meal $meal, array $data): Meal
    {
        $meal->update($data);
        return $meal->fresh(['assignedTo']);
    }
}
