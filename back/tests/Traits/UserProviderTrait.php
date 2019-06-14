<?php

namespace Tests\Traits;

use App\Models\Role;
use App\Models\User;

trait UserProviderTrait
{
    public function userProvider()
    {
        $this->refreshApplication();

        return [[factory(User::class)->create()]];
    }

    public function activeUserProvider()
    {
        $this->refreshApplication();

        return [[factory(User::class)->state('active')->create()]];
    }

    public function activeStudentProvider()
    {
        $this->refreshApplication();

        $user = factory(User::class)->state('active')->create();
        $user->roles()
            ->attach(Role::findByName(Role::STUDENT));

        return [[$user]];
    }

    public function activeStaffProvider()
    {
        $this->refreshApplication();

        $user = factory(User::class)->state('active')->create();
        $user->roles()
            ->attach(Role::findByName(Role::STAFF));

        return [[$user]];
    }

    public function activeAdministratorProvider()
    {
        $this->refreshApplication();

        $user = factory(User::class)->state('active')->create();
        $user->roles()
            ->attach(Role::findByName(Role::ADMINISTRATOR));

        return [[$user]];
    }

    public function activeDeveloperProvider()
    {
        $this->refreshApplication();

        $user = factory(User::class)->state('active')->create();
        $user->roles()
            ->attach(Role::findByName(Role::DEVELOPER));

        return [[$user]];
    }
}
