<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outstand extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'osdx';

    protected $fillable = [
        'oscdx', 'sequence', 'title', 'name', 'price', 'quantity', 'content', 'state', 'hit',
        'price_normal', 'delivery_origin_cost', 'supply', 'need_delivery_info',
    ];

    public function outstandCategory()
    {
        return $this->belongsTo('App\OutstandCategory', 'oscdx');
    }

    public function thumbnail()
    {
        return $this->hasOne('App\File', 'osdx');
    }

    public function outstandOrders()
    {
        return $this->hasMany('App\OutstandOrder', 'osdx')->where('state', '>', 0);
    }

    public function outstandItems()
    {
        return $this->hasMany('App\OutstandItem', 'osdx')->where('state', '>', 0);
    }
}
