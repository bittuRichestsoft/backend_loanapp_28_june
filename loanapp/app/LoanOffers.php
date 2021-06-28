<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanOffers extends Model
{
    protected $table = "loan_offers";
    protected $fillable = ['id', 'user_id', 'amount', 'to_be_paid', 'interest', 'installment', 'type', 'given_to', 'status', 'taken_by', 'created_at', 'updated_at'];
}
