<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $primaryKey = 'oidx';

    protected $fillable = [
        'odx', 'pdx', 'price', 'quantity', 'amount', 'delivery_origin_cost', 'delivery_kind', 'delivery_pay', 'delivery_logistics', 'delivery_address1', 'delivery_address2', 'delivery_name', 'delivery_serial', 'state'
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

            case 20:
                $state_show = "배송준비";
                break;
            case 21:
                $state_show = "배송중";
                break;
            case 22:
                $state_show = "배송완료";
                break;
            case 23:
                $state_show = "구매확정";
                break;

            case 30:
                $state_show = "교환요청";
                break;
            case 31:
                $state_show = "교환중";
                break;
            case 32:
                $state_show = "교환완료";
                break;

            case 40:
                $state_show = "환불요청";
                break;
            case 41:
                $state_show = "환불중";
                break;
            case 42:
                $state_show = "환불완료";
                break;

            default:
                $state_show = "입금대기";
        }
        return $state_show;
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'odx');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'pdx');
    }

    // public function product()
    // {
    //     return $this->hasMany('App\Product', 'pdx');
    // }
}
