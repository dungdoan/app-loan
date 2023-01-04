<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\ScheduledRepayment;
use App\Models\Status;
use App\Models\User;
use App\Services\LoanService;
use App\Services\ScheduledRepaymentService;
use App\Services\StatusService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ScheduledRepaymentTest extends TestCase
{
    /**
     * @var LoanService $loanService
     */
    private $loanService;

    /**
     * @var StatusService $statusService
     */
    private $statusService;

    /**
     * @var ScheduledRepaymentService
     */
    private $scheduledRepaymentService;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->loanService = new LoanService();
        $this->scheduledRepaymentService = new ScheduledRepaymentService();
        $this->statusService = new StatusService();
    }

    /**
     * The function will create a repayment
     *
     * @return void
     */
    public function test_a_repayment_can_be_created()
    {

    }

    /**
     * The function will test repayments of a loan
     *
     * @return void
     */
    public function test_return_repayments_of_a_loan()
    {
        $dataTest = $this->getDataTest();

        $user = User::create($dataTest['user']);
        $statuses = [];
        foreach ($dataTest['status'] as $dataStatus) {
            $statuses[] = Status::create($dataStatus);
        }
        $loan = Loan::create($dataTest['loan']);
        $scheduledRepayment = [];
        foreach ($dataTest['scheduled_repayment'] as $scheduledRepayment) {
            $scheduledRepayment[] = ScheduledRepayment::create($scheduledRepayment);
        }

        $actualResult = $this->scheduledRepaymentService->getRepaymentsArePaidByLoanId($loan->id);
        $this->assertEquals(count($dataTest['scheduled_repayment']), $actualResult->count());

        $loan->delete();
        foreach ($statuses as $status) {
            $status->delete();
        }
        $user->delete();
    }

    /**
     * Get data test for functions
     *
     * @return array
     */
    private function getDataTest()
    {
        return [
            'user' => [
                'id' => 1,
                'name' => 'Customer',
                'email' => 'test_loan_can_be_shown_by_id@test.com',
                'password' => Hash::make('customer'),
            ],
            'status' => [
                [
                    'id' => $this->statusService::PENDING_ID,
                    'status' => 'PENDING',
                ],
                [
                    'id' => $this->statusService::APPROVED_ID,
                    'status' => 'APPROVED',
                ],
                [
                    'id' => $this->statusService::PAID_ID,
                    'status' => 'PAID',
                ],
            ],
            'loan' => [
                'id' => 1,
                'user_id' => 1,
                'status_id' => $this->statusService::APPROVED_ID,
                'amount' => 999999,
                'term' => 3,
            ],
            'scheduled_repayment' => [
                [
                    'loan_id' => 1,
                    'status_id' => $this->statusService::PAID_ID,
                    'amount' => 333333,
                    'repayment_date' => '2023-01-01',
                ],
                [
                    'loan_id' => 1,
                    'status_id' => $this->statusService::PAID_ID,
                    'amount' => 333333,
                    'repayment_date' => '2023-01-08',
                ],
                [
                    'loan_id' => 1,
                    'status_id' => $this->statusService::PAID_ID,
                    'amount' => 333333,
                    'repayment_date' => '2023-01-15',
                ],
            ],
        ];
    }
}
