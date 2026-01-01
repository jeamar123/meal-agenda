<?php

namespace App\Modules\Meal\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\HouseholdMember\Http\Resources\HouseholdMemberResource;
use App\Modules\Recipe\Http\Resources\RecipeResource;

class MealResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'meal_type' => $this->meal_type,
            'date' => $this->date?->format('Y-m-d'),
            'time' => $this->time?->format('H:i'),
            'notes' => $this->notes,
            'calories' => $this->calories,
            'assigned_to' => $this->whenLoaded('assignedTo', function () {
                return $this->assignedTo ? new HouseholdMemberResource($this->assignedTo) : null;
            }),
            'recipe' => $this->whenLoaded('recipe', function () {
                return $this->recipe ? new RecipeResource($this->recipe) : null;
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
