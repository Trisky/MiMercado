<?php
/**
 * Created by PhpStorm.
 * User: Trisky
 * Date: 8/6/2018
 * Time: 1:12 AM
 */

namespace App\Meli\Products;
use App\Jobs\FetchCatalog;
use App\Meli\Auth;
use App\Meli\Connection;
use App\Meli\Settings;
use App\Meli\UnauthorizedException;

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
     * Fetches the user products from the database if they are there
     * If they are not there it queues the job that fetches them and fails
     * @param string $username
     * @return array
     * @throws CatalogNotReadyYet
     */
    public function getUserProducts(string $username) {
        $userCatalog = new CatalogStatus($username);
        try{
            (new Auth())->getAccessToken($username);
        }catch (\Exception $e){
            throw new UnauthorizedException();
        }
        $catalogStatus = $userCatalog->getCatalogStatus();
        switch ($catalogStatus){
            case $userCatalog::LOADED:
                return $this->getProductsStorage()->fetchProductsFromDatabase($username);
            case $userCatalog::NOTFOUND:
                FetchCatalog::dispatch($username);
                $userCatalog->setWaiting();
                throw new CatalogNotReadyYet($username);
            case $userCatalog::WAITING:
            case $userCatalog::LOADING;
                throw new CatalogNotReadyYet($username);
            case $userCatalog::NOTAVALILABLE:
                throw new UnauthorizedException();
            default:
                throw new \Exception($username.'_'.$catalogStatus);
        }
    }

    private function getProductsFetcher() : ProductsFetcher {
        return $this->productsFetcher;
    }
    private function getProductsStorage(): Storage {
        return $this->productsStorage;
    }

    public function fetchAndStoreProducts($username) {
        $responses = $this->getProductsFetcher()->fetchPrivateProducts($username);
        $this->getProductsStorage()->storeProducts($responses, $username);
    }

    /** @deprecated
    private function getPublicProducts(){
        $res = $client->request('GET', "https://api.mercadolibre.com/sites/MLA/search?nickname=$this->username");
    }
     */

}
