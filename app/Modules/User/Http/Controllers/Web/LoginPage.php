<?php

declare(strict_types=1);

namespace App\Modules\User\Http\Controllers\Web;

use Inertia\Inertia;
use Inertia\Response;

class LoginPage
{
    public function __invoke(): Response
    {
        return Inertia::render('Auth/Login');
    }
}
