<?php

use App\Models\Document\DocumentStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DocumentStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'Query - New',
            'New',
            'Reviewed',
            'Supported Level 1',
            'Supported Level 2',
            'Approved',
            'Denied'
        ];

        DocumentStatus::insert(
            collect($statuses)->map(function ($status) {
                return [
                    'name'  => $status,
                    'label' => Str::snake(str_replace('-', '', $status))
                ];
            })->toArray()
        );
    }
}
