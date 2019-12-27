<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers, administrators and staffs
        if ($current_user->role()->isSuperiorOrEquivalentTo(Role::STAFF) && $ability != 'destroy') {
            return true;
        }
    }

    public function index(User $current_user)
    {
        $this->deny(trans('errors.403'));
    }

    public function store(User $current_user)
    {
        $this->deny(trans('errors.403'));
    }

    public function show(User $current_user, Client $client)
    {
        $this->deny(trans('errors.403'));
    }

    public function update(User $current_user, Client $client)
    {
        $this->deny(trans('errors.403'));
    }

    public function destroy(User $current_user, Client $client)
    {
        return $current_user->role()->isEquivalentTo(Role::DEVELOPER)
            ?: (
                $current_user->role()->isInferiorTo(Role::STAFF)
                    ? $this->deny(trans('errors.403'))
                    : (
                        $client->bills()->count() === 0
                            ?: $this->deny(trans('errors.clients.bills'))
                )
            );
    }
}
