<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Loan;
use Illuminate\Http\Request;
use App\Services\LoanService;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * Define a Loan Service
     *
     * @var LoanService
     */
    private $loanService;

    /**
     * @param LoanService $loanService
     */
    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    /**
     * View seft owned loan for customer
     *
     * @param Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function index(Loan $loan)
    {
        $response = $this->loanService->getOwnLoan(Auth::id());

        return response()->json($response);
    }

    /**
     * Create a new owned loan
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $response = $this->loanService->createLoan($request->post());

        return response()->json([$response]);
    }

    /**
     * Approve a loan for customer
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request)
    {
        $response = $this->loanService->approveLoan($request->post());

        return response()->json($response);
    }
}
