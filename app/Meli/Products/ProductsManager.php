<?php
/**
 * Created by PhpStorm.
 * User: Trisky
 * Date: 8/6/2018
 * Time: 1:12 AM
 */

namespace App\Meli\Products;
use App\Meli\Connection;
use App\Meli\Settings;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Redis;



class ProductsManager
{
    private $productsFetcher;
    private $productsStorage;
    private static $instance = null;


    public function __construct(ProductsFetcher $productsFetcher,Storage $productsStorage) {
        $this->productsFetcher = $productsFetcher;
        $this->productsStorage = $productsStorage;
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            return new ProductsManager(
                new ProductsFetcher(
                    new Settings(), new Connection()),
                new Storage()
            );
        } else {
            return self::$instance;
        }
    }

    /**
     * Fetches the user products from the database or from meli if they are not present in the database
     * @return array
     */
    public function getUserProducts() {
        $products = $this->getProductsStorage()->fetchProductsFromDatabase();
        if (empty($products)) {
            $products = $this->fetchProductsFromMeli();
        }
        return $products;
    }

    /**
     * fetches products and stores them in redis
     * @return array
     * @throws \Exception
     */
    private function fetchProductsFromMeli(): array {
        $responses = $this->getProductsFetcher()->fetchPrivateProducts();
        $this->getProductsStorage()->storeProducts($responses);
        return $responses;
    }

    private function getProductsFetcher() : ProductsFetcher {
        return $this->productsFetcher;
    }
    private function getProductsStorage(): Storage {
        return $this->productsStorage;
    }

    /** @deprecated
    private function getPublicProducts(){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', "https://api.mercadolibre.com/sites/MLA/search?nickname=$this->username");
        $response = json_decode($res->getBody());
        $products = $response->results;
        return $products;
    }
     */

}
