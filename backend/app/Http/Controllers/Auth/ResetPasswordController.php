<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;

class ResetPasswordController extends Controller
{
    // عرض نموذج إعادة تعيين كلمة المرور
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // إعادة تعيين كلمة المرور
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);

        // استعادة المستخدم عبر البريد الإلكتروني
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // تحديث كلمة المرور
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();

                // إطلاق حدث لإعادة تعيين كلمة المرور
                event(new PasswordReset($user));
            }
        );

        // استجابة بناءً على النتيجة
        return $response == Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully.'])
            : response()->json(['message' => 'Failed to reset password.'], 400);
    }
}
