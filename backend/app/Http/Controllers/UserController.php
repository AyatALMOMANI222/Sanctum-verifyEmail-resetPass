<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

use function Laravel\Prompts\error;
use function Laravel\Prompts\password;

class UserController extends Controller
{

    public function store(Request $request)
    {
        try {
            // التحقق من صحة المدخلات
            $validatedData = $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'nullable|string|max:255',
                'whatsapp' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'is_admin' => 'sometimes|in:true,false', 
            ]);

            // تخزين الصورة إذا كانت موجودة
            // if ($request->hasFile('image')) {
            //     $path = $request->file('image')->store('images', 'public');
            //     $validatedData['image'] = $path;
            // } else {
            //     $validatedData['image'] = null; // إذا لم تكن هناك صورة
            // }

            // تحويل القيمة 'true' أو 'false' إلى قيمة منطقية
            $validatedData['is_admin'] = filter_var($request->input('is_admin', false), FILTER_VALIDATE_BOOLEAN);

            // إنشاء المستخدم الجديد
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'phone' => $validatedData['phone'],
                'whatsapp' => $validatedData['whatsapp'],
                'address' => $validatedData['address'],
                'location' => $validatedData['location'],
                'is_admin' => $validatedData['is_admin'],
            ]);
         
            $user->sendEmailVerificationNotification();

            // إرجاع استجابة بنجاح
            return response()->json(['message' => 'User created successfully!'], 201);
        } catch (\Exception $e) {
            // في حال حدوث أي خطأ
            return response()->json([
                'message' => 'Failed to create user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }













}
