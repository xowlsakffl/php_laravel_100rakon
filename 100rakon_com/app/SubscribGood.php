<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribGood extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'sgdx';

    protected $fillable = [
        'sgcdx', 'sequence', 'title', 'quantity', 'content', 'state', 'hit',
    ];

    public function category()
    {
        return $this->belongsTo('App\SubscribGoodCategory', 'sgcdx');
    }

    public function products()
    {
        return $this->hasMany('App\SubscribGoodProduct', 'sgdx')->orderby('sequence', 'desc');
    }

    public function orders()
    {
        return $this->hasMany('App\SubscribOrder', 'sgdx');
    }

    public function thumbnail()
    {
        return $this->hasOne('App\File', 'sgdx');
    }
}
