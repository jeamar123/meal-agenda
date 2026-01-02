<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

use function json_decode;
use function json_encode;

class MacroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->redirectResponsesMacros();
        $this->apiRouteMacros();
    }

    protected function redirectResponsesMacros(): void
    {
        RedirectResponse::macro(
            'flash',
            fn (string|array $payload) => $this->with('flash', json_encode(['payload' => $payload], JSON_THROW_ON_ERROR))
        );

        RedirectResponse::macro(
            'bannerNotification',
            fn (?string $message = null, ?string $headline = null) => $this->with('flash', json_encode(['payload' => ['bannerNotification' => [
                'headline' => $headline,
                'message' => $message,
            ]]], JSON_THROW_ON_ERROR))
        );
    }

    protected function apiRouteMacros(): void
    {
       
    }
}
