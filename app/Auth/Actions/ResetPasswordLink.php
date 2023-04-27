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

class ResetPasswordLink {
    use AsAction;
    
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function handle(ActionRequest $request)
    {
        $request->validate($this->rules());
        
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status;
    }

    public function asController(ActionRequest $request)
    {
        $status = $this->handle($request);

        $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}
