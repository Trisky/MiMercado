<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $fillable = ['id','username','product_id','visible'];
    protected $attributes = [
        'visible' => true,
    ];
    protected $guarded = [];
    use SoftDeletes;
}
