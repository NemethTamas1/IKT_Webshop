<?php

namespace App\Policies;

use App\Models\User;

class BasePolicy
{
    protected function isAdmin(User $user) {
        return "admin" == $user->role;
    }
}
