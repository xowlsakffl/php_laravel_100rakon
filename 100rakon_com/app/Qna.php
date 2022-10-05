<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qna extends Model
{
    protected $primaryKey = 'idx';

    protected $fillable = [
        'name', 'tel', 'email', 'udx', 'parent', 'content', 'state', 'hit',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'udx');
    }
}
