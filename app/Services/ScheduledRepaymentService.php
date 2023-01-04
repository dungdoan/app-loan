<?php

namespace App\Services;

use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Loan;
use App\Models\ScheduledRepayment;
use App\Services\LoanService;
use App\Services\StatusService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduledRepaymentService
{
    /** @var StatusService */
    private $statusService;

    /** @var LoanService */
    private $loanService;

    public function __construct()
    {
        $this->loanService = new LoanService;
        $this->statusService = new StatusService;
    }

    /**
     * Create a payment
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function createRepayment(Request $request)
    {
        $response = [];
        $repaymentData = $request->post();

        $repayment = ScheduledRepayment::where('id', $repaymentData['id'])->first();

        // Check current status of loan, if pending or paid, don't allow to pay
        $loan = $this->loanService->getLoanById($repayment->loan_id);
        if ($loan->status_id == $this->statusService::PENDING_ID) {
            $response = [
                'status' => 200,
                'message' => 'The loan is not approved, please contact administrator',
            ];
        }  elseif ($loan->status_id == $this->statusService::PAID_ID) {
            $response = [
                'status' => 200,
                'message' => 'The load was paid',
            ];
        } else {
            // If the repayment is found, continue
            // If the repayment is not found, return a response, finish the function
            if ($repayment) {
                // If money is paid is larger than / equal amount for repayment, continue
                // Return a response, finish the function:
                //      If money is paid is smaller than amount for repayment
                //      If the repayment is paid before
                if ($repaymentData['amount'] < $repayment->amount) {
                    $response = [
                        'status' => 200,
                        'message' => 'Money for payment need larger than current amount',
                    ];
                } elseif ($repayment->status_id == $this->statusService::PAID_ID) {
                    $response = [
                        'status' => 200,
                        'message' => 'The repayment was paid',
                    ];
                } else {
                    $repayment->update([
                        'status_id' => $this->statusService::PAID_ID,
                    ]);

                    if ($repayment->status_id != $this->statusService::PAID_ID) {
                        $response = [
                            'status' => 200,
                            'message' => 'The repayment can not be processed',
                        ];
                    } else {
                        // Check customer pays all the scheduled payment
                        // the Loan is marked automatically marked as Paid
                        $repayments = $this->getRepaymentsArePaidByLoanId($repayment->loan_id);
                        if ($this->checkLoanIsDone($loan, $repayments)) {
                            $loan->update([
                                'status_id' => $this->statusService::PAID_ID,
                            ]);
                        }

                        $response = [
                            'status' => 200,
                            'message' => 'The repayment is successful',
                        ];
                    }
                }
            } else {
                $response = [
                    'status' => 200,
                    'message' => 'Can not find the repayment',
                ];
            }
        }
        return $response;
    }

    /**
     * Get repayments are paid
     *
     * @param $loanId
     * @return array
     */
    public function getRepaymentsArePaidByLoanId($loanId)
    {
        return ScheduledRepayment::where([
                'loan_id' => $loanId,
                'status_id' => $this->statusService::PAID_ID,
            ])->get();
    }

    /**
     * Check loan is done
     *
     * @param Loan $loan
     * @param array $repayments
     * @return boolean
     */
    private function checkLoanIsDone(Loan $loan, $repayments)
    {
        return $loan->term == count($repayments);
    }
}
