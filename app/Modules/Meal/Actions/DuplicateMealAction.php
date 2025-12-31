<?php

namespace App\Modules\Meal\Actions;

use App\Modules\Meal\Models\Meal;

class DuplicateMealAction
{
    public function execute(Meal $meal): Meal
    {
        $duplicated = $meal->replicate();
        $duplicated->save();

        return $duplicated->load('assignedTo');
    }
}
