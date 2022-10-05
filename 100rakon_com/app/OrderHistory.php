<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{

    protected $primaryKey = 'idx';

    protected $fillable = [
        'odx', 'kind', 'content',
    ];

    public function order()
    {
        return $this->belongsTo('App\Order', 'odx');
    }
}
