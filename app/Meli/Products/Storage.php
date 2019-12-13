<?php


namespace App\Meli\Products;


use App\Meli\Auth;
use App\Storage\Redis;

class Storage
{
    CONST CACHE_KEY = 'products';

    public function fetchProductsFromDatabase(string $username): array {

        $jsonProducts = Redis::getFromUser(self::CACHE_KEY,$username);
        $products = [];
        if (!!$jsonProducts) {
            foreach ($jsonProducts as $jsonProduct) {
                $products[] = new Product($jsonProduct,$jsonProduct->pictures);
            }
        }
        return $products;
    }

    /**
     * @param array $responses
     */
    public function storeProducts(array $responses,$username): void {
        $catalog = new CatalogStatus($username);
        $catalog->setLoaded();
        Redis::saveForUser($responses,self::CACHE_KEY,$username);
    }

    public function clearCache($username){
        Redis::delete(self::CACHE_KEY,$username);
    }
}
