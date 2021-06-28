<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $table = "user_account";
    protected $fillable = ['user_id', 'card_number','expiray', 'cvv'];
}
