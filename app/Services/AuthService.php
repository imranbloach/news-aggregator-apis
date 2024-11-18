<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->token = $user->createToken('auth_token')->plainTextToken;

        return $user;
    }

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return null;
        }

        $user = Auth::user();
        $user->token = $user->createToken('auth_token')->plainTextToken;

        return $user;
    }

    public function logout($user)
    {
        $user->tokens()->delete();
    }
}
