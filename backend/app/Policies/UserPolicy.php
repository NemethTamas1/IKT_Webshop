<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy extends BasePolicy
{
    // Users can check their own orders 
    public function modifyData(User $user){
        //
    }
}
