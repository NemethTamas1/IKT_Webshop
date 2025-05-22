<?php

namespace App\Policies;

use App\Models\User;

class BasePolicy
{
    protected function isAdmin(User $user) {
        return "Admin" == $user->role;
    }
}
