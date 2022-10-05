<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutstandCategory extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'oscdx';

    protected $fillable = [
        'sequence', 'cname', 'parent', 'state',
    ];

    public function outstand()
    {
        return $this->hasMany('App\Outstand', 'oscdx');
    }
}
