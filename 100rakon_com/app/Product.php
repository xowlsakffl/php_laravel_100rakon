<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'pdx';

    protected $fillable = [
        'pcdx', 'sequence', 'title', 'name', 'price', 'quantity', 'content', 'state', 'hit',
        'price_normal', 'delivery_origin_cost', 'supply',
    ];

    public function productCategory()
    {
        return $this->belongsTo('App\ProductCategory', 'pcdx');
    }

    public function orderItems()
    {
        return $this->hasMany('App\OrderItem', 'pdx')->where('state', '>', 0);
    }

    public function orderBaskets()
    {
        return $this->hasMany('App\OrderBasket', 'pdx');
    }

    public function thumbnail()
    {
        return $this->hasOne('App\File', 'pdx')->where('state', '>', 0);
    }

    public function subscribProduct()
    {
        return $this->hasMany('App\SubscribProduct', 'pdx')->where('state', '>', 0);
    }
}
