<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Services\AuthService;

class AuthController extends Controller
{
    use HttpResponses;
    
    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function login(LoginRequest $request){
        $user = $this->authService->login($request);
        if(!$user){
            return $this->error($user,'Credentials does not match!',config('http_status.unauthorized'));
        }
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('ApiToken'.$user->name)->plainTextToken
        ],'Login Successfully.');
    }

    public function register(StoreUserRequest $request)
    {
        $user = $this->authService->storeUser($request);
        return $this->success($user,'Register successfully.',201);
    }
}
