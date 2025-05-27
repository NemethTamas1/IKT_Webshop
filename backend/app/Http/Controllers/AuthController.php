<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authorization(AuthenticateRequest $request) {
        $credentials = $request->validated();
        
        if(Auth::attempt($credentials)) {
            $user = $request->user();
            $token = $request->user()->createToken('UserToken');

            return response()->json([
                'data' => [
                    'token' => $token->plainTextToken,
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
