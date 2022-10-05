<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $primaryKey = 'fdx';

    protected $fillable = [
        'fdx', 'udx', 'up_name', 'real_name', 'size', 'extension', 'download', 'width', 'height', 'state', 'pdx', 'sgdx', 'osdx'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product', 'pdx');
    }

    public function subscribGood()
    {
        return $this->belongsTo('App\SubscribGood', 'sgdx');
    }

    public function outstand()
    {
        return $this->belongsTo('App\Outstand', 'osdx');
    }
}
