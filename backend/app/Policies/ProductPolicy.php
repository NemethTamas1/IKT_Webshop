<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class ProductPolicy extends BasePolicy
{
    public function viewAny(User $user): Response
    {
        Log::info($user->role);

        return $this->isAdmin($user)
            ? Response::allow()
            : Response::deny();
    }

    public function view(User $user, Product $product): bool
    {
        return true;
    }

    public function create(User $user): Response
    {
        return $this->isAdmin($user)
            ? Response::allow()
            : Response::deny("Adminisztrátornak kell lennie!");
    }

    public function update(User $user, Product $product): bool
    {
        return true;
    }

    public function delete(User $user, Product $product): bool
    {
        return true;
    }

    public function restore(User $user, Product $product): bool
    {
        return true;
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return true;
    }
}
