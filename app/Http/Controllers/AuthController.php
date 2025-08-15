<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Requests\Store\StoreRegisterRequest;
use App\Http\Requests\Store\StoreLoginRequest;

use App\Models\User;

class AuthController extends Controller
{
    public function login(StoreLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $token = JWTAuth::attempt($credentials);

        if(!$token) {
            return response()->json(['error' => 'Token não autorizado'], 401);
        }

        return response()->json(['token' => $token]);
    }

    public function register(StoreRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'profile' => $request->profile,
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token], 201);
    }    
}
