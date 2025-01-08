<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\ValidationException as ValidationValidationException;

class AuthController extends Controller
{
    //

    

    /**
     * Handle user login and issue a token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'The provided credentials are incorrect.'], 401);
        }
    
        // التحقق من أن المستخدم قد قام بالتحقق من بريده الإلكتروني
        if (!$user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Please verify your email address first.'], 403);
        }
    
        // التحقق من صحة كلمة المرور
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'The provided credentials are incorrect.'], 401);
        }
    

        // Create a token for the user
        $token = $user->createToken('Res')->plainTextToken;

        // Return the token and user data including isAdmin
        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'is_admin' => $user->is_admin, // Include isAdmin in the response
            ],
        ]);
    }

    /**
     * Get the authenticated user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile(Request $request)
    {
        // Get the authenticated user from the token
        $user = $request->user();

        // Return the user details
        return response()->json([
            'user' => $user,
            'isAdmin' => $user->is_admin, // Include isAdmin in the response
        ]);
    }


    /**
     * Log the user out (revoke the token).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */


    public function logout(Request $request)
    {
        // Check if the user is authenticated
        if (!$request->user()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. No token provided or invalid token.',
            ], 401);
        }

        // Revoke the current user's token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully.',
        ], 200);
    }
}
