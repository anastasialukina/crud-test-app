<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);
            $expiresAt = now()->addMinutes(5);

            $tokenRecord = Token::create([
                'user_id' => Auth::id(),
                'access_token' => $token,
                'expires_at' => $expiresAt,
                'last_used_at' => now()
            ]);


            return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_at' => $expiresAt->toIso8601String(),
                ]
            ]);
        }

        return response()->json([
            'error' => 'Invalid credentials',
        ], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);
        $expiresAt = now()->addMinutes(5);

        $tokenRecord = Token::create([
            'user_id' => Auth::id(),
            'access_token' => $token,
            'expires_at' => $expiresAt,
            'last_used_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        $user = Auth::user();
        $token = JWTAuth::getToken();
        $new_token = JWTAuth::refresh($token);
        $expiresAt = now()->addMinutes(5);

        $tokenRecord = Token::create([
            'user_id' => Auth::id(),
            'access_token' => $new_token,
            'expires_at' => $expiresAt,
            'last_used_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $new_token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function user()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
        ]);
    }
}
