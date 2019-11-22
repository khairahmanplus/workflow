<?php

use App\Models\Module\Module;
use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            'Document'
        ];

        Module::insert(
            collect($modules)->map(function ($module) {
                return [
                    'name' => $module
                ];
            })->toArray()
        );
    }
}
