<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers, administrators and staffs
        if ($current_user->role()->isInferiorTo(Role::STAFF)) {
            return false;
        }
    }

    public function index(User $current_user)
    {
        return true;
    }

    public function store(User $current_user)
    {
        return true;
    }

    public function show(User $current_user, Contact $contact)
    {
        return true;
    }

    public function update(User $current_user, Contact $contact)
    {
        return true;
    }

    public function destroy(User $current_user, Contact $contact)
    {
        return true;
    }
}
