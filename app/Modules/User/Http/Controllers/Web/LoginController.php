<?php

declare(strict_types=1);

namespace App\Modules\User\Http\Controllers\Web;

use Inertia\Inertia;
use Inertia\Response;
use App\Enums\Role;
use Illuminate\Http\RedirectResponse;
use App\Modules\User\Actions\LoginUserAction;
use App\Modules\User\Http\Requests\LoginUserRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function __invoke(
        LoginUserRequest $request,
        LoginUserAction $login,
    ): RedirectResponse 
    {
        $user = $login->execute(
            $request->only('email', 'password'),
            $request->input('remember', false)
        );

        dd($user);
        
        if(!$user){
            throw ValidationException::withMessages([
                'password' => __('The provided credentials do not match our records.'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/');
    }
}
