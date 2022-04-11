<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required | string',
            'email' => 'required | string | unique:users,email',
            'password' => 'required | string | confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
        $token = $user->createToken('showapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            "message" => "logged out"
        ];
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email'=> 'required | string',
            'password' => 'required | string'
        ]);

        $user = User::where('email', $fields['email'])->first();
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                "message" => "Incorrect credentials"], 401);
        }
        $token = $user->createToken('showapptoken')->plainTextToken; 

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
        
    }

    public function userData()
    {
        return auth()->user();
    }
}
