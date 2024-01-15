<?php

namespace App\Http\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class AuthService
{
    public function login($request)
    {
        $user = null;
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return $user;
        }
        $user = User::where('email',$request->email)->first();
        return $user;
    }

    public function storeUser($request) {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
}