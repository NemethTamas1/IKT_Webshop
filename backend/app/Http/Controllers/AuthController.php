<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Pail\ValueObjects\Origin\Console;

class AuthController extends Controller
{
    public function authorization(AuthenticateRequest $request) {
        $credentials = $request->validated();
        
        if(Auth::attempt($credentials)) {
            $user = $request->user();

            $tokenName = $user->role === 'admin' ? 'AdminToken' : 'UserToken';

            $token = $request->user()->createToken($tokenName);
            
            return response()->json([
                'data' => [
                    'token' => $token->plainTextToken,
                    'tokenType' => $tokenName,
                    'user' => $user
                ]
            ]);


        } else {
            return response()->json([
                'data' => [
                    'message' => 'Unauthorized'
                ]], 401);
        }
    }
}
