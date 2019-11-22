<?php

use App\Models\Authorization\Role;
use App\User;
use Illuminate\Database\Seeder;

class AdministratorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'      => 'Khai Rahman',
            'email'     => 'khairahman@netboxs.com',
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);

        $user->roles()->attach(Role::where('label', 'administrator')->value('id'));
    }
}
