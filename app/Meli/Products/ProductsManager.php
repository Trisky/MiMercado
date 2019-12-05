<?php
/**
 * Created by PhpStorm.
 * User: Trisky
 * Date: 8/6/2018
 * Time: 1:12 AM
 */

namespace App\Meli\Products;
use App\Meli\Auth;
use App\Meli\Connection;
use App\Meli\Settings;

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
                    new Settings(), new Connection(),new Auth()),
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
    public function getUserProducts(string $username) {
        $products = $this->getProductsStorage()->fetchProductsFromDatabase($username);
        if (empty($products)) {
            $products = $this->fetchProductsFromMeli($username);
        }
        return $products;
    }

    /**
     * fetches products and stores them in redis
     * @return array
     * @throws \Exception
     */
    private function fetchProductsFromMeli(string $username): array {
        $username = strtoupper($username);
        $responses = $this->getProductsFetcher()->fetchPrivateProducts($username);
        $this->getProductsStorage()->storeProducts($responses,$username);
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
        $res = $client->request('GET', "https://api.mercadolibre.com/sites/MLA/search?nickname=$this->username");
    }
     */

}
