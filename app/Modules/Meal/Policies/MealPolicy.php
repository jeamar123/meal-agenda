<?php

namespace App\Modules\Meal\Policies;

use App\Modules\User\Models\User;
use App\Modules\Meal\Models\Meal;

class MealPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Meal $meal): bool
    {
        return $user->id === $meal->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Meal $meal): bool
    {
        return $user->id === $meal->user_id;
    }

    public function delete(User $user, Meal $meal): bool
    {
        return $user->id === $meal->user_id;
    }

    public function duplicate(User $user, Meal $meal): bool
    {
        return $user->id === $meal->user_id;
    }
}
