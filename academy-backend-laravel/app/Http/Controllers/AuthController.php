<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class AuthController extends Controller
{
    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
//            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' requires a password_confirmation field
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $user = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'family' => $request->family,
                'password' => Hash::make($request->password),
                'role'   => 'ordinary'
            ]);
            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Check user credentials
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = $user->createToken('m89aHIst8')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function logout(Request $request) {
        // Revoke the token that was used to authenticate the user
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }


}
