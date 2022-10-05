<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'uadx';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uadx', 'udx', 'title', 'zipcode', 'address1', 'address2', 'name', 'tel', 'msg'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'udx');
    }
}
