<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($req->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('access_token')->plainTextToken;

            return response()->json(['access_token' => $token], 201);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}

