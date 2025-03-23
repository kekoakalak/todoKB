<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password'=> 'required|string|min:8'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

    // Generate JWT token
     $token = JWTAuth::fromUser($user);
     return response()->json(['token' => $token], 201);   // HTTP 201: Created
    }

    public function login(Request $request)
        {
            $credentials = $request->only('email', 'password');
            if (!$token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'Unauthorized'], 401); // HTTP 401: Unauthorized
            }
            return response()->json(['token' => $token], 200); // HTTP 200: OK
        }

        public function me()
        {
            return response()->json(auth()->user());
        }
}


