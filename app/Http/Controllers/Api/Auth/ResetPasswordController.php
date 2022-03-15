<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function sendResetLink(Request $r)
    {
        $r->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($r->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['status' => __($status)])
            : response()->json(['email' => __($status)], 422);
    }

    public function resetPassword(Request $r)
    {
        $r->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:15']
        ]);

        $status = Password::reset(
            $r->only('token', 'email', 'password', 'password_confirmation'),
            function($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['status' => __($status)])
            : response()->json(['email' => [__($status)]], 422);
    }
}
