<?php

namespace App\Modules\Meal\Actions;

use App\Modules\Meal\Models\Meal;

class CreateMealAction
{
    public function execute(array $data): Meal
    {
        $meal = Meal::create($data);
        return $meal->load('assignedTo');
    }
}
