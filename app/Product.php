<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    public $id;
    public $user;
    public $product_id;
    public $visible = true;

    public function hide(){
        $this->visible = false;
        return $this;
    }
    public function show(){
        $this->visible = true;
        return $this;
    }
}
