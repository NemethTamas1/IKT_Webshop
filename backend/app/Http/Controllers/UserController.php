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

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'data' => $user->only(['role', 'name', 'phone', 'country', 'city', 'zip', 'street_name', 'street_type', 'street_number', 'floor', 'email', 'role']) // csak ezek
        ]);
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
