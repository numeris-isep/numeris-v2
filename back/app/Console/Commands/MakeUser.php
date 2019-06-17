<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Symfony\Component\Console\Exception\LogicException;

class MakeUser extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user {--u|username= : Username}
                {--p|password : Prompt for password}
                {--f|first_name= : First name}
                {--l|last_name= : Last name}
                {--e|email= : Email address}
                {--r|role=student : Role (student, staff, administrator or developer)}
                {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        if (Role::all()->isEmpty()) {
            throw new LogicException("Database's table 'roles' must be seeded before creating an user.");
        }

        $options = $this->options();
        $user_data = [];
        $password = 'azerty';

        if ($options['password']) {
            $password = $this->secret('User\'s password');
            $user_data['password'] = bcrypt($password);
        }

        if ($options['role'] && ! in_array($options['role'], Role::roles())) {
            throw new LogicException("User's role must be either 'student', 'staff', 'administrator' or 'developer'");
        }

        foreach ($options as $key => $value) {
            if (! is_bool($value) && ! is_null($value) && $key != 'role') {
                $user_data[$key] = $value;
            }
        }

        // Create the user
        $user = factory(User::class)->state('active')->create($user_data);
        $user->setRole(Role::findByName($options['role'] ?: 'student'));

        if (User::find($user->id)) {
            $this->info("User created successfully!\n");
            $this->line('You might want to login with the following credentials: ');

            $this->table(
                ['Email', 'Password'],
                [[$user->email, $password]]
            );
        }
    }
}
