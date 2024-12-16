<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth; 
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash; // Import Hash facade

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
            'password_confirmation' => 'required|same:password',
        ]);
        $errorMessages = $validator->errors()->all(); 
        if ($validator->fails()) {
            return response()->json(['message'=>$errorMessages,'status'=>422]);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Use Hash::make
        ]);

        // Generate JWT token for the user
        try {
            $token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return response()->json([
            'status'=>200,
            'message' => 'user registered successfully!'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth()->user();
        return response()->json([
            'status'=>200,
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id,
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }


    public function logout(Request $request)
    {
        try {
          
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out'
            ]);
        } catch (JWTException $e) {
            return response()->json([
               'success' => false,
                'message' => 'Failed to logout, please try again'
            ], 500);
        }
    }
}
