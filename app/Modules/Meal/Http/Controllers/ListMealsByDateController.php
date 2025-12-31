<?php

namespace App\Modules\Meal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Meal\Actions\ListMealsByDateAction;
use App\Modules\Meal\Http\Resources\MealResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListMealsByDateController extends Controller
{
    public function __invoke(Request $request, ListMealsByDateAction $action)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $meals = $action->execute(Auth::id(), $request->input('date'));

        return MealResource::collection($meals);
    }
}
