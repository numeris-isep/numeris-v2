<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers
        if ($current_user->role()->isEquivalentTo(Role::DEVELOPER)) {
            return true;
        }
    }

    public function index(User $current_user)
    {
        return $current_user->role()->isSuperiorTo(Role::STUDENT)
            ?: $this->deny(trans('errors.403'));
    }

    public function indexPromotion(User $current_user)
    {
        return $current_user->role()->isSuperiorTo(Role::STUDENT)
            ?: $this->deny(trans('errors.403'));
    }

    public function indexUserApplication(User $current_user, User $user)
    {
        // $user1 whose $role < 'developer' can't see $user2's applications
        // unless   $user1 == $user2
        // or       $user1->role > 'student'
        return (
            $current_user->is($user)
            || $current_user->role()->isSuperiorTo(Role::STUDENT)
        ) ?: $this->deny(trans('errors.403'));
    }

    public function show(User $current_user, User $user)
    {
        // $user1 whose $role < 'developer' can't show the profile of $user2
        // unless   $user1 == $user2
        // or       $user1->role > 'student'
        return (
            $current_user->is($user)
            || $current_user->role()->isSuperiorTo(Role::STUDENT)
        ) ?: $this->deny(trans('errors.403'));
    }

    public function update(User $current_user, User $user)
    {
        // $user1 whose $role < 'developer' can't update $user2
        // unless   $user1 == $user2
        // or       $user1->role > $user2->role
        return $current_user->is($user)
            ?: (
                $current_user->role()->isInferiorOrEquivalentTo($user->role()->name)
                    ? $this->deny(trans('errors.roles.' . $current_user->role()->name))
                    : true
            );
    }

    public function updateTermsOfUse(User $current_user, User $user)
    {
        // $user1 whose $role < 'developer' can't update the TOU of $user2
        // unless   $user1 == $user2
        // or       $user1->role > $user2->role
        return (
            $current_user->is($user)
            || $current_user->role()->isSuperiorTo(Role::STUDENT)
        ) ?: $this->deny(trans('errors.403'));
    }

    public function updateActivated(User $current_user, User $user)
    {
        // $user1 whose $role < 'developer' can't activate $user2
        // unless   $user1->role >= 'staff'
        // AND      $user1->role > $user2->role
        return $current_user->role()->isInferiorTo(Role::STAFF)
            ? $this->deny(trans('errors.403'))
            : (
                $current_user->role()->isInferiorOrEquivalentTo($user->role()->name)
                    ? $this->deny(trans('errors.roles.' . $current_user->role()->name))
                    : (
                        ! $user->is_completed
                            ? $this->deny(trans('errors.users.completed'))
                            : (
                                ! $user->tou_accepted
                                    ? $this->deny(trans('errors.users.tou_accepted'))
                                    : (
                                        is_null($user->email_verified_at)
                                            ? $this->deny(trans('errors.users.email_verified_at'))
                                            : true
                                )
                        )
                )
            );
    }

    public function destroy(User $current_user, User $user)
    {
        // $user1 whose $role < 'administrator' can't delete the profile of $user2
        // unless   $user1 == $user2
        return (
            $current_user->is($user)
            || $current_user->role()->isSuperiorTo(Role::STAFF)
        ) ?: $this->deny(trans('errors.roles.' . $current_user->role()->name));
    }
}
