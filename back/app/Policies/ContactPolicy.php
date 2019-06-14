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
        if ($current_user->role()->isSuperiorOrEquivalentTo(Role::STAFF)) {
            return true;
        }
    }

    public function index(User $current_user)
    {
        return false;
    }

    public function store(User $current_user)
    {
        return false;
    }

    public function show(User $current_user, Contact $contact)
    {
        return false;
    }

    public function update(User $current_user, Contact $contact)
    {
        return false;
    }

    public function destroy(User $current_user, Contact $contact)
    {
        return false;
    }
}
