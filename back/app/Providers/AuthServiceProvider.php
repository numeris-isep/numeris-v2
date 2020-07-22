<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Convention;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\Mission;
use App\Models\Payslip;
use App\Models\Preference;
use App\Models\Project;
use App\Models\Rate;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Policies\ApplicationPolicy;
use App\Policies\BillPolicy;
use App\Policies\ClientPolicy;
use App\Policies\ContactPolicy;
use App\Policies\ConventionPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\MessagePolicy;
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
use App\Exceptions\AuthorizationException;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use HandlesAuthorization;

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class         => UserPolicy::class,
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
        Invoice::class      => InvoicePolicy::class,
        Message::class      => MessagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // This gate defines if a user can apply to a mission
        Gate::define('store-application', function(User $current_user, User $user, Mission $mission) {
            return $user->hasAppliedTo($mission)
                ? $this->deny($current_user, trans('errors.application_exists'))
                : (
                    $mission->is_locked
                        ? $this->deny($current_user, trans('errors.mission_locked'))
                        : (
                            Carbon::parse($mission->start_at)->isBefore(now())
                                ? $this->deny($current_user, trans('errors.mission_expired'))
                                : (
                                $mission->project->step != Project::HIRING
                                    ? $this->deny($current_user, trans_choice('errors.wrong_project_step', 1, ['step' => 'Ouvert']))
                                    : (
                                        ! $mission->project->is_private
                                            ?: (
                                                $user->belongsToProject($mission->project)
                                                    ?: $this->deny($current_user, trans('errors.project_doesnot_contain_user'))
                                        )
                                )
                            )
                    )
                );
        });

        Gate::define('store-mission-application', function(User $current_user, User $user, Mission $mission) {
            return $current_user->role()->isInferiorTo(Role::STAFF)
                ? $this->deny($current_user, trans('errors.roles.' . Role::STUDENT))
                : (
                    $user->deleted_at
                        ? $this->deny($current_user, trans('errors.profile_deleted'))
                        : (
                            $user->hasAppliedTo($mission)
                                ? $this->deny($current_user, trans('errors.application_exists'))
                                : (
                                    $mission->project->step != Project::HIRING
                                        ? $this->deny($current_user, trans_choice('errors.wrong_project_step', 1, ['step' => 'Ouvert']))
                                        : (
                                            ! $mission->project->is_private
                                                ?: (
                                                    $user->belongsToProject($mission->project)
                                                        ?: $this->deny($current_user, trans('errors.project_doesnot_contain_user'))
                                            )
                                    )
                            )
                    )
                );
        });
    }

    /**
     * @param string $message
     * @throws AuthorizationException
     */
    private function deny(User $user, string $message)
    {
        throw new AuthorizationException(
            $user->role()->isInferiorTo(Role::STAFF)
                ? trans('errors.roles.' . Role::STUDENT)
                : $message
        );
    }
}
