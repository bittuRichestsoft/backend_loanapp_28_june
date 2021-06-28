<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmiHistory extends Model
{
    // use SoftDeletes;

    protected $table = 'emi_history';
    protected $dates = [
        'created_at',
        'updated_at',
        // 'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'loan_id',
        'installment',
        'created_at',
        'updated_at',
        // 'deleted_at',
    ];
}
