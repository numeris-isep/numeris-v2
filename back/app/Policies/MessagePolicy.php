<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use App\Models\Message;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy extends AbstractPolicy
{
    public function before(User $current_user, $ability)
    {
        // Grant everything to  administrators and staffs
        if ($current_user->role()->isInferiorTo(Role::ADMINISTRATOR) && $ability != 'current') {
            return false;
        }
    }

    public function index(User $current_user)
    {
        return true;
    }

    public function current(User $current_user)
    {
        return true;
    }

    public function store(User $current_user)
    {
        return true;
    }

    public function update(User $current_user, Message $message)
    {
        return true;
    }

    public function updateActivated(User $current_user, Message $message)
    {
        return true;
    }

    public function destroy(User $current_user, Message $message)
    {
        return true;
    }
}
