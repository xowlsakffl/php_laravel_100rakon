<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribOrder extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'sodx';

    protected $fillable = [
        'order_number', 'udx', 'sgdx', 'term', 'delivery_times', 'pay_term', 'pay_total_times', 'pay_day',
        'start_date', 'end_date', 'member_transform', 'total_amount', 'use_point', 'pay_amount', 'pay_kind', 'pay_name',
        'pay_company', 'pay_tel', 'pay_cell', 'pay_email', 'delivery_zipcode', 'delivery_address1', 'delivery_address2',
        'delivery_name', 'delivery_tel', 'delivery_msg', 'receipt_kind', 'company_regist_number', 'company_name',
        'company_president_name', 'company_address', 'company_kind1', 'company_kind2', 'company_charge_email',
        'person_name', 'person_unique_number', 'state', 'order_name', 'order_tel',
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

    // 구매자
    public function user()
    {
        return $this->belongsTo('App\User', 'udx');
    }

    // 해당 상품
    public function good()
    {
        return $this->belongsTo('App\SubscribGood', 'sgdx');
    }

    // 관련 제품들
    public function items()
    {
        return $this->hasMany('App\SubscribOrderItem', 'sodx');
    }

    // 히스토리
    public function histories()
    {
        return $this->hasMany('App\SubscribOrderHistory', 'sodx');
    }

    // Toss 관련 내역
    public function toss()
    {
        $toss = PayTossTransaction::where('orderId', $this->order_number)->get();
        return $toss;
    }
}
