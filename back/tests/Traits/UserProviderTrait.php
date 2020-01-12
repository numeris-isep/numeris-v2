<?php

namespace Tests\Traits;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;

trait UserProviderTrait
{
    public function userProvider(): User
    {
        return factory(User::class)->create();
    }

    public function activeUserProvider(): User
    {
        return factory(User::class)->state('active')->create();
    }

    public function deletedUserProvider(): User
    {
        return factory(User::class)->state('deleted')->create();
    }

    public function activeStudentProvider(): User
    {
        $user = factory(User::class)->state('active')->create();
        factory(UserRole::class)->create([
            'role_id'       => Role::findByName(Role::STUDENT)->id,
            'user_id'       => $user->id,
            'created_at'    => now()->subMonth(),
            'updated_at'    => now()->subMonth(),
        ]);

        return $user;
    }

    public function activeStaffProvider(): User
    {
        $user = factory(User::class)->state('active')->create();
        factory(UserRole::class)->create([
            'role_id'       => Role::findByName(Role::STAFF)->id,
            'user_id'       => $user->id,
            'created_at'    => now()->subMonth(),
            'updated_at'    => now()->subMonth(),
        ]);

        return $user;
    }

    public function activeAdministratorProvider(): User
    {
        $user = factory(User::class)->state('active')->create();
        factory(UserRole::class)->create([
            'role_id'       => Role::findByName(Role::ADMINISTRATOR)->id,
            'user_id'       => $user->id,
            'created_at'    => now()->subMonth(),
            'updated_at'    => now()->subMonth(),
        ]);

        return $user;
    }

    public function activeDeveloperProvider(): User
    {
        $user = factory(User::class)->state('active')->create();
        factory(UserRole::class)->create([
            'role_id'       => Role::findByName(Role::DEVELOPER)->id,
            'user_id'       => $user->id,
            'created_at'    => now()->subMonth(),
            'updated_at'    => now()->subMonth(),
        ]);

        return $user;
    }
}
