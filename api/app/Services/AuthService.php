<?php

namespace App\Services;

use Exception;
use Illuminate\Auth\AuthenticationException;

class AuthService
{
    public function login(array $credentials)
    {
        if (!$token = auth()->attempt($credentials)) {
            throw new AuthenticationException();
        }

        return ['token' => $token];
    }

    public function logout()
    {
        try{
            auth()->logout();
        }catch(Exception $e){
            throw new AuthenticationException();
        }

        return response()->json(['message' => 'Successfully logged out']);
    }
}
