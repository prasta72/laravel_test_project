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

class ViewResetPasswordPage {
    use AsAction;

    public function asController(ActionRequest $request)
    {
        return view('auth.reset-password', ['request' => $request]);
    }
    
}
