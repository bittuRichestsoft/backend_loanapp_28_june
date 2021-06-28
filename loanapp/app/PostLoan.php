<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostLoan extends Model
{
    protected $table = "post_loan";

    public function user()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }


    public function durations()
    {
    	return $this->belongsTo('App\LoanDuration','duration_id','id');
    }
}