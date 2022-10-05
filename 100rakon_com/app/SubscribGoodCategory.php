<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribGoodCategory extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'sgcdx';

    protected $fillable = [
        'sequence', 'cname', 'parent', 'state',
    ];

    public function goods()
    {
        return $this->hasMany('App\SubscribGood', 'sgcdx');
    }
}
