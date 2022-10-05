<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribOrderHistory extends Model
{
    protected $primaryKey = 'idx';

    protected $fillable = [
        'sodx', 'kind', 'content',
    ];

    public function order()
    {
        return $this->belongsTo('App\SubscribOrder', 'sodx');
    }
}
