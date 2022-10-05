<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsSend extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'idx';

    protected $fillable = [
        'udx', 'odx', 'sender', 'receiver', 'msg', 'msg_type', 'title', 'destination', 'rdate', 'rtime', 'image', 'testmode_yn',
        'result_code', 'msg_id', 'success_cnt', 'error_cnt', 'state',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'udx');
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'odx');
    }
}
