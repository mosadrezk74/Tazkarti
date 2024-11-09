<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'f_name' => ['required', 'string', 'max:14'],
            'l_name' => ['required', 'string', 'max:14'],
            'image' => ['required', 'image', 'max:1024'],
            'nation_id'=> ['required', 'integer','digits:14','unique:users'],
            'dob'=> ['required', 'date'],
            'gender' => ['required', 'integer', 'in:0,1'],
            'nationality'=> ['required', 'integer'],
            'language'=> ['required', 'integer', 'in:0,1'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            'status'=> ['required', 'integer', 'in:0,1'],

        ]);
        $imagePath = $request->file('image')->store('uploads', 'public');

        $user = User::create([
            'f_name' => $validated['f_name'],
            'l_name' => $validated['l_name'],
            'image' => $imagePath,
            'nation_id' => $validated['nation_id'],
            'dob' => $validated['dob'],
            'gender' => $validated['gender'],
            'nationality' => $validated['nationality'],
            'language' => $validated['language'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'password_confirmation' => bcrypt($validated['password']),
            'status' => $validated['status'],
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request){
        $validated = request()->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
        $user = User::where('email', $validated['email'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'The provided credentials are incorrect.'], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token]);
    }
}
