<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribOrderItem extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'soidx';

    protected $fillable = [
        'sodx', 'sgpdx', 'price', 'quantity', 'amount', 'state',
    ];

    public function order()
    {
        return $this->belongsTo('App\SubscribOrder', 'sodx');
    }

    // public function product()
    // {
    //     return $this->hasOne('App\SubscribGoodProduct', 'sgpdx');
    // }

    public function product()
    {
        return $this->belongsTo('App\SubscribGoodProduct', 'sgpdx');
    }
}
