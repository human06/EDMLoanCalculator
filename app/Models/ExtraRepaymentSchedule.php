<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraRepaymentSchedule extends Model
{
    use HasFactory;
    public $table = 'extra_repayment_schedule';
    public $guarded = [];
}
