<?php


namespace App\Meli\Products;


use App\Meli\Auth;
use Illuminate\Support\Facades\Redis;

class Storage
{
    CONST CACHE_KEY = 'products';

    public function fetchProductsFromDatabase(): array {
        $jsonProducts = json_decode(Redis::get(self::CACHE_KEY));
        $products = [];
        if (!!$jsonProducts) {
            foreach ($jsonProducts as $jsonProduct) {
                $products[] = new Product(1, $jsonProduct);
            }
        }
        return $products;
    }

    /**
     * @param array $responses
     */
    public function storeProducts(array $responses): void {
        Redis::setex(self::CACHE_KEY, 60 * 60 * 24, json_encode($responses));
    }

    public function clearCache(){
        Redis::del(self::CACHE_KEY);
    }

}
