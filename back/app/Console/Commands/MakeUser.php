<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Models\Preference;
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

        if (! isset($options['username']) || ! isset($options['email']) || ! isset($options['first_name']) || ! isset($options['last_name'])) {
            throw new LogicException("Some options are missing.");
        }

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
        $user = User::create(array_merge($user_data, [
            'activated'                 => true,
            'tou_accepted'              => true,
            'student_number'            => random_int(1000, 99999),
            'promotion'                 => random_int(2015, 2025),
            'school_year'               => 'A1',
            'phone'                     => "0" . (string) random_int(100000000, 999999999),
            'nationality'               => 'france',
            'birth_date'                => '2000-01-01',
            'birth_city'                => 'Paris',
        ]));

        // Attach role
        $user->setRole(Role::findByName($options['role'] ?: 'student'));

        // Create adresse
        Address::create([
            'street'    => '1 rue quelquepart',
            'city'      => 'Paris',
            'zip_code'  => 75001,
        ])->user()->save($user);

        // Create preference
        Preference::create([
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
        ])->user()->save($user);

        // Check if it worked
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
