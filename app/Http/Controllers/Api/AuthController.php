<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('LaravelPassport')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Login user account by email and password credentials
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token =  Auth::user()->createToken('backend-app')->accessToken;

        return response()->json([
            'token' => $token
        ], 200);
    }

    /**
     * Logout the authenticated user and revoke their access token.
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'token' => null
        ], 200);
    }
}
