<?php

namespace App\Modules\HouseholdMember\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHouseholdMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('householdMember')->user_id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'color' => 'sometimes|nullable|string|max:7',
            'sort_order' => 'sometimes|nullable|integer',
        ];
    }
}
