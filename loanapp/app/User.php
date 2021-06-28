<?php

namespace App;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

  public static function validateSessionId($session_id) {
    $user_data = DB::table('app_login')->where( 'session_id', $session_id )->first();
    if (empty ( $user_data )) return 0;
    else return $user_data->user_id;
  }

  public static function fetchDevicetype($session_id) {
    $user_data = DB::table('app_login')->where( 'session_id', $session_id )->first();
    if (empty ( $user_data )){
        return 0;
    }
    else
    {
       $device_type=$user_data->device_type;
       return $device_type;
    }
    
  }
    public static function getUser($result)
    {
        return [
          'user_id' => $result->id,
          'first_name' => $result->first_name,
          'last_name' => $result->last_name,
          'email'=> $result->email,
          'phone' => $result->phone,
          'gender' => $result->gender,
          'dob' => $result->dob,
          'id_number' => $result->id_number,
          'cred_score'=> $result->cred_score,
          'bank_account' => $result->bank_account,
          'source_of_income' => $result->source_of_income,
          'id_doc' => ($result->id_doc) ? env('APP_URL').'/public/uploads/id_doc/'.$result->id_doc : '',
        ];
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
