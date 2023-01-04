<?php

namespace Tests\Unit;

use App\Services\LoanService;
use PHPUnit\Framework\TestCase;

class LoanTest extends TestCase
{
    /**
     * This function will test methods in Loan Service are existing
     *
     * @return void
     */
    public function test_loan_service_methods_existing()
    {
        $this->assertTrue(method_exists(new LoanService(), 'getOwnLoan'));
        $this->assertTrue(method_exists(new LoanService(), 'createLoan'));
        $this->assertTrue(method_exists(new LoanService(), 'approveLoan'));
        $this->assertTrue(method_exists(new LoanService(), 'getLoanById'));
    }
}
