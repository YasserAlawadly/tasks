<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|min:8|max:255',
        ]);

        if (!auth()->attempt($request->only('email', 'password'))) {
            return api_response(false, 'These credentials do not match our records.' , [] , 422);
        }

        return api_response(true, 'login successfully' , new UserResource(auth()->user()->with('roles')->first()));
    }
}
