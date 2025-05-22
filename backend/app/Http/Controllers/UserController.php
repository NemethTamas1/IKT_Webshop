<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return UserResource::collection($user);
    }

    public function store(RegisterUserRequest $request, User $user)
    {
        $data = $request->validated();
        $user = User::create($data);
        return new UserResource($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $user->update($data);
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        return ($user->delete()) ? response()->noContent() : abort(500);
    }
}
