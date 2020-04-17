<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            // Admin
            [
                'name'	        => 'Admin',
                'email'         => 'info@siberfx.com',
                'password'      => bcrypt('demo'),
                'salutation'    => 'Mr.',
                'birthday'		=> now()->toDateString(),
                'gender'		=> 1,
                'active'		=> 1,
                'created_at'    => now()
            ],
            // Client
            [
                'name'          => 'Client',
                'email'         => 'client@siberfx.com',
                'password'      => bcrypt('demo'),
                'salutation'    => 'Mr.',
                'birthday'      => now()->subYears(20)->toDateString(),
                'gender'        => 1,
                'active'        => 1,
                'created_at'    => now()
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
