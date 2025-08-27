<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    protected static string $view = 'back.login';
    protected static string $layout = 'layouts.guest'; // example: resources/views/layouts/guest.blade.php

    public function getTitle(): string | Htmlable
    {
        return 'Eminent Studio - Login';
    }

    public function getHeading(): string | Htmlable
    {
        return 'Sign in';
    }
}
