<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // عرض نموذج "نسيت كلمة المرور"
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email'); // عرض الصفحة التي تطلب من المستخدم إدخال بريده الإلكتروني
    }

    // إرسال رابط إعادة تعيين كلمة المرور
    public function sendResetLinkEmail(Request $request)
    {
        // التحقق من صحة البريد الإلكتروني
        $request->validate(['email' => 'required|email']);

        // إرسال رابط إعادة تعيين كلمة المرور
        $response = Password::sendResetLink(
            $request->only('email')
        );

        // استجابة بناءً على النتيجة
        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent to your email.'])
            : response()->json(['message' => 'Unable to send reset link.'], 400);
    }
}

