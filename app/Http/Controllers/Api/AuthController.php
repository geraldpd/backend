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
     * @api {post} /api/register Register a New User
     * @apiName RegisterUser
     * @apiGroup Authentication
     *
     * @apiBody {String} name User's name.
     * @apiBody {String} email User's email address.
     * @apiBody {String} password User's password.
     * @apiBody {String} password_confirmation Password confirmation.
     *
     * @apiSuccess {String} token Access token for the registered user.
     *
     * @apiError {Object} error List of validation errors.
     * @apiErrorExample {json} Validation Error:
     *     HTTP/1.1 400 Bad Request
     *     {
     *       "error": {
     *         "email": ["The email has already been taken."],
     *         "password": ["The password must be at least 8 characters."]
     *       }
     *     }
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
     * @api {post} /api/login Login User
     * @apiName LoginUser
     * @apiGroup Authentication
     *
     * @apiBody {String} email User's email address.
     * @apiBody {String} password User's password.
     *
     * @apiSuccess {String} token Access token for the authenticated user.
     *
     * @apiError {String} error Unauthorized access error.
     * @apiErrorExample {json} Unauthorized:
     *     HTTP/1.1 401 Unauthorized
     *     {
     *       "error": "Unauthorized"
     *     }
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
     * @api {post} /api/logout Logout User
     * @apiName LogoutUser
     * @apiGroup Authentication
     *
     * @apiHeader {String} Authorization Bearer {token}.
     *
     * @apiSuccess {Null} token Null indicating the user has been logged out.
     *
     * @apiError {String} error Error message if logout fails.
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 500 Internal Server Error
     *     {
     *       "error": "Could not revoke token."
     *     }
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'token' => null
        ], 200);
    }
}
