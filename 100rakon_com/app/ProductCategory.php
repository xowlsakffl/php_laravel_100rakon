<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'pcdx';

    protected $fillable = [
        'sequence', 'cname', 'parent', 'state',
    ];

    public function products()
    {
        return $this->hasMany('App\Product', 'pcdx');
    }
}
