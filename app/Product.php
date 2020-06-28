<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
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

    public static function getProductsFromUser(string $username,array $meliIds): Collection{
        return self::where('username',$username)
            ->whereIn('product_id',$meliIds)
            ->get();
    }
}
