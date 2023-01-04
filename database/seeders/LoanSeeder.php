<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->getLoanData();

        foreach($data as $loanItem) {
            DB::table('loans')->insert($loanItem);
        }
    }

    /**
     * @return array[]
     */
    private function getLoanData()
    {
        return [
            [
                'id' => 1,
                'amount' => 100000,
                'term' => 2,
                'user_id' => 2,
                'status_id' => 1,
                'created_at' => '2023-01-01 08:17:56',
                'updated_at' => '2023-01-01 08:17:56',
            ],
            [
                'id' => 2,
                'amount' => 210000,
                'term' => 3,
                'user_id' => 3,
                'status_id' => 1,
                'created_at' => '2023-01-02 08:17:56',
                'updated_at' => '2023-01-02 08:17:56',
            ],
        ];
    }
}
