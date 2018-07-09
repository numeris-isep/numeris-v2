<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Client;
use App\Models\Preference;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Policies\AddressPolicy;
use App\Policies\ClientPolicy;
use App\Policies\PreferencePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\UserRolePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class         => UserPolicy::class,
        Address::class      => AddressPolicy::class,
        Preference::class   => PreferencePolicy::class,
        Role::class         => RolePolicy::class,
        UserRole::class     => UserRolePolicy::class,
        Client::class       => ClientPolicy::class,
        Project::class      => ProjectPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
