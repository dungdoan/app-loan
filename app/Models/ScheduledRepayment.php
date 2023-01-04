<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledRepayment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, int, double, date>
     */
    protected $fillable = [
        'loan_id',
        'status_id',
        'amount',
        'repayment_date',
    ];
}
