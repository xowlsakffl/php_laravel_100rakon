<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    protected $primaryKey = 'udx';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'name', 'email_auth', 'email_verified_at', 'cell', 'cell_auth', 'cell_authed_at', 'tel', 'join_from',
        'super', 'state', 'personal_agree', 'remember_token',
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
        'cell_authed_at' => 'datetime',
    ];

    public function userAddresses()
    {
        return $this->hasMany('App\UserAddress', 'udx')->orderby('uadx', 'desc');
    }

    public function orders()
    {
        return $this->hasMany('App\Order', 'udx')->where('state', '>', 0)->with('items')->orderby('odx', 'DESC');
    }

    public function orderBaskets()
    {
        return $this->hasMany('App\OrderBasket', 'udx')->where('state', '>', 0);
    }

    public function subscribOrders()
    {
        return $this->hasMany('App\SubscribOrder', 'udx')->where('state', '>', 0)->orderby('created_at', 'desc');
    }

    public function outstandOrders()
    {
        return $this->hasMany('App\OutstandOrder', 'udx')->where('state', '>', 0)->orderby('created_at', 'desc');
    }

    public function smsSends()
    {
        return $this->hasMany('App\SmsSend', 'udx');
    }

    public function qnas()
    {
        return $this->hasMany('App\Qna', 'udx');
    }

    //상태에 따른 설명값 리턴
    public function getStateText()
    {
        switch ($this->state)
        {
            case 9:
                $state_text = "대기";
                break;
            case 8:
                $state_text = "정지";
                break;
            case 1:
                $state_text = "탈퇴";
                break;
            case 0:
                $state_text = "삭제";
                break;
            default:
                $state_text = "정상";
        }
        return $state_text;
    }
    //가입한 경로(소셜로그인) 리턴
    public function getJoinFromText()
    {
        switch ($this->join_from)
        {
            case 'kakao':
                $join_from_text = "카카오";
                break;
            case 'naver':
                $join_from_text = "네이버";
                break;
            default:    //home
                $join_from_text = "홈페이지";
        }
        return $join_from_text;
    }
}
