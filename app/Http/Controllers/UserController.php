<?php

namespace App\Http\Controllers;

use App\Services\UserProfileService;

class UserController extends Controller
{
    public function me()
    {
        $user = auth()->user();
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'profile' => $user->profile,
        ]);
    }
    public function userProfiles()
    {
        return response()->json(UserProfileService::all());
    }
}
