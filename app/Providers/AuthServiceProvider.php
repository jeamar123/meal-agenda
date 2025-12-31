<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Modules\HouseholdMember\Models\HouseholdMember::class => \App\Modules\HouseholdMember\Policies\HouseholdMemberPolicy::class,
        \App\Modules\Meal\Models\Meal::class => \App\Modules\Meal\Policies\MealPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        //
    }
}
