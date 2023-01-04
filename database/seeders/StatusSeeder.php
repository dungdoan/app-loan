<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->getStatuses();

        foreach($data as $statusItem) {
            DB::table('statuses')->insert($statusItem);
        }
    }

    /**
     * @return array[]
     */
    private function getStatuses()
    {
        return [
            [
                'id' => 1,
                'status' => 'PENDING',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'status' => 'APPROVED',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'status' => 'PAID',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
    }
}
