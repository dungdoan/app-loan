# Information
* The mini-app is developed based on **Laravel framework 9** and built fully functional REST API without any UI
* Postman API collections:

# Requirements
**Main idea:** Customer can create a loan with amount and term, they can repay it weekly until finish all term.

**1. Customer create a loan:**
   * Customer submit a loan request defining amount and term
   example:
     * Request amount of 10.000 $ with term 3 on date 7th Feb 2022
     he will generate 3 scheduled repayments:
       * 14th Feb 2022 with amount 3.333,33 $
       * 21st Feb 2022 with amount 3.333,33 $
       * 28th Feb 2022 with amount 3.333,34 $
       * the loan and scheduled repayments will have state **PENDING**

**2. Admin approve the loan:**
   * Admin change the pending loans to state **APPROVED**

**3. Customer can view loan belong to him:**
   * Add a policy check to make sure that the customers can view them own loan only.

**4. Customer add a repayments:**
   * Customer add a repayment with amount greater or equal to the scheduled repayment
   * The scheduled repayment change the status to **PAID**
   * If all the scheduled repayments connected to a loan are **PAID** automatically also the loan become **PAID**

## Set up and run app on local
* Clone source code from: https://github.com/dungdoan/app-loan.git
* Put source code in the main folder that will be run by webserver and create virtual host for it.
* Run ```php artisan migrate``` (for creating database and tables)
* Run ```php artisan db:seed``` (for creating sample data)
* Run the app with ```virtual domain```

### Routes for running the app
Routes will be begin by virtual domain and prefix ```api/```, I use my virtual
```http://app-loan.local```, so routes will be begin with ```http://app-loan.local/api```
#### Auth
* Create user ```(POST)```: ```/auth/register```
* Login ```(POST)```: ```/auth/login```
* Logout ```(POST)```: ```/auth/logout```

#### Loan
* Create loan ```(POST)```: ```/loan/create```
* Get owned loan ```(GET)```: ```/loan```
* Approve loan ```(POST)```: ```/loan/approve```

#### Payment
* Create loan ```(POST)```: ```/repayment/create```

### Testing commands
* Unit test:
  * Loan: ```php artisan test --filter=test_loan_service_methods_existing```
  * Repayment: ```php artisan test --filter=test_scheduled_repayment_service_methods_existing```

* Feature test:
    * Loan:
      * ```php artisan test --filter=test_loan_can_be_created```
      * ```php artisan test --filter=test_loan_can_be_approved```
      * ```php artisan test --filter=test_loan_can_be_shown_by_own```
      * ```php artisan test --filter=test_loan_can_be_shown_by_id```
    * Repayment:
        * ```php artisan test --filter=test_a_repayment_can_be_created```
        * ```php artisan test --filter=test_return_repayments_of_a_loan```



