<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loans extends Model
{
    protected $table = "loans";
    protected $fillable = ['id', 'user_id', 'given_to','temp_phone', 'taken_by', 'amount', 'to_be_paid','duration_type', 'installment', 'interest','admin_interest','user_interest', 'status','loan_status','request_to','created_by', 'created_at', 'updated_at'];
}
