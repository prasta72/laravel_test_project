<?php

namespace App\Auth\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class ConfirmablePassword {
    use AsAction;
    
    public function rules()
    {
        return [
            'email' => $request->user()->email,
            'password' => $request->password,
        ];
    }

    public function handle(ActionRequest $request)
    {
        if (! Auth::guard('web')->validate($this->rules())) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());
    }

    public function asController(ActionRequest $request)
    {
        $this->handle($request);

        return redirect()->intended(RouteServiceProvider::HOME);
    }
    
}
