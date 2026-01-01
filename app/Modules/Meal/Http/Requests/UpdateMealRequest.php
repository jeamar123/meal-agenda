<?php

namespace App\Modules\Meal\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('meal')->user_id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'meal_type' => ['sometimes', 'required', Rule::in(['breakfast', 'lunch', 'dinner', 'snack'])],
            'date' => 'sometimes|required|date',
            'time' => 'nullable|date_format:H:i',
            'assigned_to_id' => 'nullable|uuid|exists:household_members,id',
            'recipe_id' => 'nullable|uuid|exists:recipes,id',
            'notes' => 'nullable|string',
            'calories' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Meal name is required',
            'meal_type.required' => 'Please select a meal type',
            'meal_type.in' => 'Invalid meal type selected',
            'date.required' => 'Date is required',
            'assigned_to_id.exists' => 'Selected household member not found',
            'calories.min' => 'Calories must be a positive number',
        ];
    }
}
