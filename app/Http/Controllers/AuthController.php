<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registration(Request $req)
    {


        try {

            $req->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:4',
            ]);

            $user = User::create([
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully',
                'access_token' => $token,

            ]);
        } catch (\Illuminate\Validation\ValidationException $err) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $err->errors()
            ], 422);
        }
    }

    public function login(Request $req)
    {
        try {
            // validation inside try block
            $req->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $err) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $err->errors()
            ], 422);
        }

        // attempt login
        if (!Auth::attempt($req->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        // user
        $user = Auth::user();

        // delete previous tokens
        $user->tokens()->delete();

        // generate new token
        $token = $user->createToken('auth_token')->plainTextToken;

        // response
        return response()->json([
            'message' => 'User logged in successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout( Request $req ){
        $req->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User logged out successfully'
        ]);
    }
}
