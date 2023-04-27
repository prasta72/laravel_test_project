<?php

namespace App\Auth\Actions;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\ActionRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Lorisleiva\Actions\Concerns\AsAction;

class UserLogin {
    use AsAction;

    public function handle(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
    }

    public function asController(LoginRequest $request)
    {
        $this->handle($request);

        return redirect()->intended(RouteServiceProvider::HOME);
    }
    
}
