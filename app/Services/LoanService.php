<?php

namespace App\Services;

use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Loan;
use App\Models\ScheduledRepayment;
use App\Services\StatusService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanService
{
    /** @var StatusService */
    private $statusService;

    public function __construct()
    {
        $this->statusService = new StatusService;
    }

    /**
     * Get self owned loan
     *
     * @param $userId
     * @return array
     */
    public function getOwnLoan($userId)
    {
        return Loan::where('user_id', $userId)
            ->join('statuses', 'status_id', '=', 'statuses.id')
            ->select('loans.amount', 'loans.term', 'statuses.status')
            ->get();
    }

    /**
     * Create an owned loan
     *
     * @param array $loanData
     * @return array
     */
    public function createLoan(array $loanData)
    {
        $response = [];
        if (!Auth::id()) {
            return [
                'status' => 200,
                'message' => 'The user is invalid',
            ];
        }

        $loanData['status_id'] = $this->statusService::PENDING_ID;
        $loanData['user_id'] = Auth::id();
        $loan = Loan::create($loanData);
        if ($loan) {
            for ($i=1; $i<=$loan->term; $i++) {
                $scheduledRepayment = [
                    'repayment_date' => Carbon::parse($loan->created_at)->addDays(7*$i)->format('Y-m-d h:i:s'),
                    'loan_id' => $loan->id,
                    'amount' => $loan->amount/$loan->term,
                    'status_id' => $this->statusService::PENDING_ID,
                ];
                ScheduledRepayment::create($scheduledRepayment);
            }
            $response = [
                'status' => 200,
                'message' => 'The loan is created',
            ];
        }

        return $response;
    }

    /**
     * @param array $loanData
     * @return array
     */
    public function approveLoan(array $loanData): array
    {
        $response = [];

        $loanId = $loanData['loan_id'];
        $loan = Loan::where([
                'id' => $loanId,
                'status_id' => $this->statusService::PENDING_ID,
            ])
            ->first();

        if ($loan) {
            $loan->update(['status_id' => $this->statusService::APPROVED_ID]);
            if ($loan->status_id == $this->statusService::APPROVED_ID) {
                $response = [
                    'status' => 200,
                    'message' => 'The loan is approved',
                ];
            } else {
                $response = [
                    'status' => 200,
                    'message' => 'The loan could not approved',
                ];
            }
        } else {
            $response = [
                'status' => 200,
                'message' => 'The loan is approved or paid',
            ];
        }

        return $response;
    }

    /**
     * @param $loanId
     * @return mixed
     */
    public function getLoanById($loanId)
    {
        return Loan::where('id', $loanId)->first();
    }
}
