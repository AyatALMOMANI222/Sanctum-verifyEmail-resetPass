<?php

use Illuminate\Support\Facades\Route;


Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = \App\Models\User::findOrFail($id);

    // التحقق من تطابق الهش مع البريد الإلكتروني
    if (hash_equals($hash, sha1($user->getEmailForVerification()))) {
        $user->markEmailAsVerified();

        return response()->json(['message' => 'Email verified successfully!']);
    }

    return response()->json(['message' => 'Invalid verification link.'], 400);
})->middleware(['signed'])->name('verification.verify');

