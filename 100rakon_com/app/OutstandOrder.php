<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutstandOrder extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'osodx';

    protected $fillable = [
        'order_number', 'udx', 'total_amount', 'use_point', 'pay_amount', 'pay_kind', 'pay_name', 'pay_tel', 'delivery_zipcode',
        'delivery_address1', 'delivery_address2', 'delivery_name', 'delivery_tel', 'delivery_msg', 'receipt_kind', 'company_regist_number',
        'company_name', 'company_president_name', 'company_address', 'company_kind1', 'company_kind2', 'company_charge_email', 'person_name',
        'person_unique_number', 'state', 'order_name', 'order_tel',
    ];

    //상태에 따른 설명값
    public function getStateShowAttribute()
    {
        switch ($this->state)
        {
            case 9:
                $state_show = "입금완료";
                break;
            case 1:
                $state_show = "주문취소";
                break;
            case 0:
                $state_show = "삭제";
                break;
            default:
                $state_show = "입금대기";
        }
        return $state_show;
    }

    //상태에 따른 설명값 리턴
    static function getStateText($state)
    {
        switch ($state)
        {
            case 9:
                $state_text = "입금완료";
                break;
            case 1:
                $state_text = "주문취소";
                break;
            case 0:
                $state_text = "삭제";
                break;
            default:
                $state_text = "입금대기";
        }
        return $state_text;
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'udx');
    }

    public function histories()
    {
        return $this->hasMany('App\OutstandHistory', 'osodx');
    }
    
    public function outstandItems()
    {
        return $this->hasMany('App\OutstandItem', 'osodx')->where('state', '>', 0);
    }
}
