<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribGoodProduct extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'sgpdx';

    protected $fillable = [
        'sgdx', 'pdx', 'sequence', 'quantity_per_delivery', 'delivery_per_month', 'is_basic', 'unit_price_normal',
        'unit_price_half', 'unit_price_year', 'state'
    ];

    public function good()
    {
        return $this->belongsTo('App\SubscribGood', 'sgdx');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'pdx');
    }

    public function subscribOrderItems()
    {
        return $this->hasMany('App\SubscribOrderItem', 'sgpdx');
    }
}
