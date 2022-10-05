<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayTossTransaction extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'tossidx';

    protected $fillable = [
        'udx', 'mId', 'version', 'paymentKey', 'orderId', 'orderName', 'method', 'status', 'requestedAt', 'approvedAt', 'useEscrow', 'cultureExpense',
        'card_company', 'card_number', 'card_installmentPlanMonths', 'card_isInterestFree', 'card_approveNo', 'card_useCardPoint', 'card_cardType',
        'card_ownerType', 'card_acauireStatus', 'card_receiptUrl',
        'virtual_accountType', 'virtual_accountNumber', 'virtual_bank', 'virtual_customerName', 'virtual_dueDate', 'virtual_refundStatus',
        'virtual_expired', 'virtual_settlementStatus',
        'transfer_bank', 'transfer_settlementStatus', 'mobile_carrier', 'mobile_customerMobilePhone', 'mobile_settlementStatus',
        'gift_approveNo', 'gift_settlementStatus', 'cashRct_type', 'cashRct_amount', 'cashRct_taxFreeAmount', 'cashRct_issueNumber',
        'cashRct_receiptUrl', 'cancel_amount', 'cancel_reason', 'cancel_taxFreeAmount', 'cancel_taxAmount', 'cancel_refundableAmount',
        'cancel_canceledAt', 'card_discount_amount',
        'secret', 'type', 'easyPay', 'currency', 'totalAmount', 'balanceAmount', 'suppliedAmount', 'vat', 'taxFreeAmount', 'state',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'udx');
    }

    public function order()
    {
        $order = Order::where('order_number', $this->orderId)->get();
        return $order;
    }
}
