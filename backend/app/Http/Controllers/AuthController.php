<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authorization(AuthenticateRequest $request) {
        $credentials = $request->validated();

        if(Auth::attempt($credentials)) {
            $token = $request->user()->createToken('UserToken');

            return response()->json([
                'data' => [
                    'message' => $token->plainTextToken
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
