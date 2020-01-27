<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

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
//        'created_at' => 'datetime:YYYY-MM-DDThh:mm:ss.sTZD',
//        'modify_at' => 'datetime:YYYY-MM-DDThh:mm:ss.sTZD',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modify_at';
    //protected $dateFormat = 'c';

    protected $dates = [
        'created_at', 'modify_at',
    ];

//    public function getDateFormat()
//    {
//        return 'YYYY-MM-DDThh:mm:ss.sTZD';
//    }

    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->setTimezone('Europe/Kiev')->format('Y-m-d\TH:i:sP');
    }

    public function getModifyAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->setTimezone('Europe/Kiev')->format('Y-m-d\TH:i:sP');
    }
}
