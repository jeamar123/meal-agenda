<?php

namespace App\Modules\Meal\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateMealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'meal_type' => ['required', Rule::in(['breakfast', 'lunch', 'dinner', 'snack'])],
            'date' => 'required|date',
            'time' => 'nullable|date_format:H:i',
            'assigned_to_id' => 'nullable|uuid|exists:household_members,id',
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

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);
        $validated['user_id'] = Auth::id();

        return $validated;
    }
}
