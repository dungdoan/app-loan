<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\Status;
use App\Models\User;
use App\Services\LoanService;
use App\Services\StatusService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoanTest extends TestCase
{
    /**
     * @var LoanService $loanService
     */
    private $loanService;

    /**
     * @var StatusService $statusService
     */
    private $statusService;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->loanService = new LoanService();
        $this->statusService = new StatusService();
    }

    /**
     * The function will test loan can be created
     *
     * @return void
     */
    public function test_loan_can_be_created()
    {

    }

    /**
     * The function will test loan can be approved
     *
     * @return void
     */
    public function test_loan_can_be_approved()
    {
        $dataTest = $this->getDataTest();

        $user = User::create($dataTest['user']);
        $statuses = [];
        foreach ($dataTest['status'] as $dataStatus) {
            $statuses[] = Status::create($dataStatus);
        }
        $loan = Loan::create($dataTest['loan']);

        $this->loanService->approveLoan(['loan_id' => $loan->id]);
        $actualResult = $this->loanService->getLoanById($loan->id);

        $this->assertEquals($actualResult->status_id, $this->statusService::APPROVED_ID);

        $user->delete();
        foreach ($statuses as $status) {
            $status->delete();
        }
        $loan->delete();
    }

    /**
     * The function will test loan can be shown by own
     *
     * @return void
     */
    public function test_loan_can_be_shown_by_own()
    {
        $dataTest = $this->getDataTest();

        $user = User::create($dataTest['user']);
        $statuses = [];
        foreach ($dataTest['status'] as $dataStatus) {
            $statuses[] = Status::create($dataStatus);
        }
        $loan = Loan::create($dataTest['loan']);

        $actualResult = $this->loanService->getOwnLoan($user->id);
        $this->assertTrue(1 == $actualResult->count());

        $user->delete();
        foreach ($statuses as $status) {
            $status->delete();
        }
        $loan->delete();
    }

    /**
     * The function will test loan can be shown by id
     *
     * @return void
     */
    public function test_loan_can_be_shown_by_id()
    {
        $dataTest = $this->getDataTest();

        $user = User::create($dataTest['user']);
        $statuses = [];
        foreach ($dataTest['status'] as $dataStatus) {
            $statuses[] = Status::create($dataStatus);
        }
        $loan = Loan::create($dataTest['loan']);

        $actualResult = $this->loanService->getLoanById($loan->id);
        foreach ($dataTest['loan'] as $columnName => $value) {
            $this->assertEquals($dataTest['loan'][$columnName], $actualResult->$columnName);
        }

        $user->delete();
        foreach ($statuses as $status) {
            $status->delete();
        }
        $loan->delete();
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
                'status_id' => $this->statusService::PENDING_ID,
                'amount' => 999999,
                'term' => 3,
            ]
        ];
    }
}
