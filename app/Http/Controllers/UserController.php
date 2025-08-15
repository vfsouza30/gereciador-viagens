<?php

namespace App\Http\Controllers;

use App\Services\UserProfileService;

class UserController extends Controller
{
    public function userProfiles()
    {
        return response()->json(UserProfileService::all());
    }
}
