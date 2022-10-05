<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutstandHistory extends Model
{
    protected $primaryKey = 'idx';

    protected $fillable = [
        'osodx', 'kind', 'content',
    ];

    public function outstandOrder()
    {
        return $this->belongsTo('App\OutstandOrder', 'osodx');
    }
}
