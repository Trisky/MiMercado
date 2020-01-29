<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $fillable = ['id','username','product_id','visible'];
    use SoftDeletes;
//    public $id;
//    public $username;
//    public $product_id;
//    public $visible = true;

    public function hide(){
        $this->visible = false;
        return $this;
    }
    public function show(){
        $this->visible = true;
        return $this;
    }
}
