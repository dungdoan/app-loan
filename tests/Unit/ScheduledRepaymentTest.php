<?php

namespace Tests\Unit;

use App\Services\ScheduledRepaymentService;
use PHPUnit\Framework\TestCase;

class ScheduledRepaymentTest extends TestCase
{
    /**
     * This function will test methods in ScheduledRepaymentService are existing
     *
     * @return void
     */
    public function test_scheduled_repayment_service_methods_existing()
    {
        $this->assertTrue(method_exists(new ScheduledRepaymentService(), 'createRepayment'));
        $this->assertTrue(method_exists(new ScheduledRepaymentService(), 'getRepaymentsArePaidByLoanId'));
        $this->assertTrue(method_exists(new ScheduledRepaymentService(), 'checkLoanIsDone'));
    }
}
