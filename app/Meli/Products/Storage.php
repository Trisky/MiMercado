<?php


namespace App\Meli\Products;


use App\Meli\Auth;
use App\Storage\Redis;

class Storage
{
    CONST CACHE_KEY = 'products';

    /**
     * @param string $username
     * @param bool $onlyVisibleProducts
     * @return Product[]
     */
    public function fetchProductsFromDatabase(string $username,bool $onlyVisibleProducts = true): array {

        $jsonProducts = Redis::getFromUser(self::CACHE_KEY,$username);
        $products = [];
        if (!!$jsonProducts) {
            foreach ($jsonProducts as $jsonProduct) {
                $product = new Product($jsonProduct,$jsonProduct->pictures);
                $products[$product->getMeliId()] = $product;
            }
        }
        $products = $this->addVisibilityInformation($username,$products);
        if($onlyVisibleProducts){
            $products =  array_filter($products,function(Product $p){
                return $p->isVisible() ;
            });
        }
        return array_values($products); //arrays with keys are transformed into objects when json_encoded
    }

    /**
     * @param array $responses
     */
    public function storeProducts(array $responses,$username): void {
        Redis::saveForUser($responses,self::CACHE_KEY,$username);
    }

    public function clearCache($username){
        Redis::delete('*',$username);
    }

    /**
     * @param string $username
     * @param Product[] $products
     * @return Product[]
     */
    private function addVisibilityInformation(string $username, array $products)  :array{
        $meliIds = array_keys($products);
        $modelProducts = \App\Product::getProductsFromUser($username, $meliIds);
        foreach ($modelProducts as $modelProduct){
            $product = $products[$modelProduct->product_id];
            $product->setVisible($modelProduct->visible);
        }
        return $products;
    }
}
