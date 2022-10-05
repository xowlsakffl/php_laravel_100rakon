<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderBasket extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'obdx';

    protected $fillable = [
        'obdx', 'udx', 'pdx', 'price', 'quantity'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'udx');
    }

    public function orderItems()
    {
        return $this->hasMany('App\OrderItem', 'odx');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'pdx');
    }
}
