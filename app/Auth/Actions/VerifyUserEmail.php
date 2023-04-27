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

class VerifyUserEmail {
    use AsAction;

    public function handle(ActionRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
    }

    public function asController(ActionRequest $request)
    {
        $this->handle($request);

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
    
}
