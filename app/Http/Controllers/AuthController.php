<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $req) {

        $validator = Validator::make($req->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Email already taken',
            ], 400);
        }

        $user = User::create([
            'email' => $req->email,
            'password' => $req->password,
        ]);

        return response()->json([
            'message' => 'User successfully registered',
        ], 201);
    }
}
