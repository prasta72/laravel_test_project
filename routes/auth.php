<?php

use App\Auth\Actions\UserLogin;
use App\Auth\Actions\UserLogout;
use App\Auth\Actions\NewUserPassword;
use App\Auth\Actions\RegisterNewUser;
use App\Auth\Actions\VerifyUserEmail;
use Illuminate\Support\Facades\Route;
use App\Auth\Actions\ResetPasswordLink;
use App\Auth\Actions\ConfirmablePassword;
use App\Auth\Actions\ViewLoginAccountPage;
use App\Auth\Actions\VerifyUserEmailPrompt;
use App\Auth\Actions\ViewCreateAccountPage;
use App\Auth\Actions\ViewResetPasswordPage;
use App\Auth\Actions\VerifyUserEmailNotification;
use App\Auth\Actions\ViewConfirmablePasswordPage;
use App\Auth\Actions\ViewSendLinkResetPasswordPage;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::middleware('guest')->group(function () {
    Route::get('register', ViewCreateAccountPage::class)->name('register');

    Route::post('register', RegisterNewUser::class);

    Route::get('login', ViewLoginAccountPage::class)->name('login');

    Route::post('login', UserLogin::class);

    Route::get('forgot-password', ViewSendLinkResetPasswordPage::class)->name('password.request');

    Route::post('forgot-password', ResetPasswordLink::class)->name('password.email');

    Route::get('reset-password/{token}', ViewResetPasswordPage::class)->name('password.reset');

    Route::post('reset-password', NewUserPassword::class)->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', VerifyUserEmailPrompt::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyUserEmail::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', VerifyUserEmailNotification::class)
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', ViewConfirmablePasswordPage::class)
                ->name('password.confirm');

    Route::post('confirm-password', ConfirmablePassword::class);

    Route::post('logout', UserLogout::class)->name('logout');
});
