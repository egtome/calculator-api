<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserOperation;

class UserOperationObserver
{
    /**
     * Handle the UserOperation "created" event.
     *
     * @param  \App\Models\UserOperation  $userOperation
     * @return void
     */
    public function created(UserOperation $userOperation)
    {
        // Deduct balance from user, commented for now since this will be done with a TRIGGER in user_operations table
        //$user = User::find($userOperation->user_id);
        //$user->balance -= $userOperation->amount;
        
        //$user->save();
    }
}
