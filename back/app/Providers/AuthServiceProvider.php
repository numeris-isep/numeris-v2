<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Application;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Convention;
use App\Models\Mission;
use App\Models\Payslip;
use App\Models\Preference;
use App\Models\Project;
use App\Models\Rate;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Policies\AddressPolicy;
use App\Policies\ApplicationPolicy;
use App\Policies\BillPolicy;
use App\Policies\ClientPolicy;
use App\Policies\ContactPolicy;
use App\Policies\ConventionPolicy;
use App\Policies\MissionPolicy;
use App\Policies\PayslipPolicy;
use App\Policies\PreferencePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\ProjectUserPolicy;
use App\Policies\RatePolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\UserRolePolicy;
use App\ProjectUser;
use Carbon\Carbon;
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
        Convention::class   => ConventionPolicy::class,
        Mission::class      => MissionPolicy::class,
        Application::class  => ApplicationPolicy::class,
        Rate::class         => RatePolicy::class,
        ProjectUser::class  => ProjectUserPolicy::class,
        Contact::class      => ContactPolicy::class,
        Bill::class         => BillPolicy::class,
        Payslip::class      => PayslipPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('store-application', function(User $current_user, User $user, Mission $mission) {
            return ! $user->hasAppliedTo($mission)
                && ! $mission->is_locked
                && Carbon::parse($mission->start_at)->isAfter(now())
                && $mission->project->step == Project::HIRING
                && ($mission->project->is_private ? $user->belongsToProject($mission->project) : true);
        });

        Gate::define('store-mission-application', function(User $current_user, User $user, Mission $mission) {
            return $current_user->role()->isSuperiorOrEquivalentTo(Role::STAFF)
                && Gate::allows('store-application', [$user, $mission]);
        });
    }
}
