<?php

declare(strict_types=1);

use Illuminate\Http\RedirectResponse;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

function domain_path(string $path = ''): string
{
    return app_path('Domain' . ($path !== '' && $path !== '0' ? DIRECTORY_SEPARATOR . $path : $path));
}

function success_response(?string $message = null, ?string $route = null): RedirectResponse
{
    $redirect = is_null($route) ? back() : redirect($route);

    return $redirect->bannerNotification($message);
}

if (!function_exists('sanitize_html')) {
    function sanitize_html(string $html): string
    {
        $config = (new HtmlSanitizerConfig())
            ->allowSafeElements()
            ->allowStaticElements()
            ->withMaxInputLength(20000); // prevent giant payloads

        return (new HtmlSanitizer($config))->sanitize($html);
    }
}

