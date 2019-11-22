<?php

use App\Models\Authorization\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name'                  => 'Super Administrator',
            'label'                 => 'super_administrator',
            'has_all_permissions'   => true
        ]);
    }
}
