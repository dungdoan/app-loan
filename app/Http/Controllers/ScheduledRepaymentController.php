<?php

namespace App\Http\Controllers;

use App\Models\ScheduledRepayment;
use App\Http\Requests\StoreScheduledRepaymentRequest;
use App\Http\Requests\UpdateScheduledRepaymentRequest;
use App\Services\ScheduledRepaymentService;
use Illuminate\Http\Request;

class ScheduledRepaymentController extends Controller
{
    /** @var ScheduledRepaymentService */
    private $scheduledRepaymentService;

    /**
     * @param ScheduledRepaymentService $scheduledRepaymentService
     */
    public function __construct(ScheduledRepaymentService $scheduledRepaymentService)
    {
        $this->scheduledRepaymentService = $scheduledRepaymentService;
    }

    /**
     * Show the form for creating a new repayment.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $response = $this->scheduledRepaymentService->createRepayment($request);

        return response()->json([$response]);
    }
}
