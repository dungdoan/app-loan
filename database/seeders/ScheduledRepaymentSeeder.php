<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduledRepaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->getScheduledRepaymentData();

        foreach($data as $repaymentItem) {
            DB::table('scheduled_repayments')->insert($repaymentItem);
        }
    }

    /**
     * @return array[]
     */
    private function getScheduledRepaymentData()
    {
        return [
            [
                'loan_id' => 1,
                'amount' => 50000,
                'repayment_date' => '2023-01-12',
                'status_id' => 1,
                'created_at' => '2023-01-01 08:17:56',
                'updated_at' => '2023-01-01 08:17:56',
            ],
            [
                'loan_id' => 1,
                'amount' => 50000,
                'repayment_date' => '2023-01-19',
                'status_id' => 1,
                'created_at' => '2023-01-01 08:17:56',
                'updated_at' => '2023-01-01 08:17:56',
            ],
            [
                'loan_id' => 2,
                'amount' => 70000,
                'repayment_date' => '2023-01-9',
                'status_id' => 1,
                'created_at' => '2023-01-02 08:17:56',
                'updated_at' => '2023-01-02 08:17:56',
            ],
            [
                'loan_id' => 2,
                'amount' => 70000,
                'repayment_date' => '2023-01-16',
                'status_id' => 1,
                'created_at' => '2023-01-02 08:17:56',
                'updated_at' => '2023-01-02 08:17:56',
            ],
            [
                'loan_id' => 1,
                'amount' => 70000,
                'repayment_date' => '2023-01-23',
                'status_id' => 2,
                'created_at' => '2023-01-02 08:17:56',
                'updated_at' => '2023-01-02 08:17:56',
            ],
        ];
    }
}
