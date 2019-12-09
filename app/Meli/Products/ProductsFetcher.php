<?php


namespace App\Meli\Products;


use App\Meli\Auth;
use App\Meli\Connection;
use App\Meli\NoAccessDataException as NoAccessDataException;
use App\Meli\Settings;
use GuzzleHttp\Exception\ClientException;

class ProductsFetcher
{
    CONST BASEURL = "https://api.mercadolibre.com";

    private $settings;
    private $connection;
    private $auth;

    /**
     * @return Connection
     */
    private function getConnection(): Connection {
        return $this->connection;
    }

    public function __construct(Settings $settings,Connection $connection,Auth $auth) {
        $this->connection = $connection;
        $this->settings = $settings;
        $this->auth = $auth;
    }

    /**
     * @param $responses
     * @return array
     */
    public function fetchPrivateProducts(string $username) {
        if(empty($username)){
            throw new \Exception('username must be provided to be able to fetch the products');
        }
        $token = $this->getAuth()->getAccessToken($username);
        $userId = $this->getAuth()->getUserId($username);
        if (empty($token) || empty($userId)) {
            throw new \Exception("Missing token or userId, token=$token, userid=$userId");
        }

        $response = $this->getConnection()->callWithToken(self::BASEURL."/users/$userId/items/search",$token);
        $products = $this->parseProductsFromResponseAndFetchDescriptions($response);
        return $products;
    }

    /**
     * @return Settings
     */
    private function getSettings(): Settings {
        return $this->settings;
    }



    /**
     * @param $productsResponse
     * @param array $products
     * @return array
     * @throws \Exception
     */
    private function parseProductsFromResponseAndFetchDescriptions($productsResponse): array {
        $products = [];
        $articleIds = $productsResponse->results;
        foreach ($articleIds as $articleId) {
            $productData = $this->fetchProduct($articleId);
            $productData->description  = '';// $this->fetchProductDescription($articleId);
            $product = $this->buildProduct($productData);
            $products[] = $product;
        }
        return $products;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    private function fetchProductDescription($id) {
        $url = self::BASEURL."/items/$id/description";
        return  $this->getConnection()->call($url)->plain_text;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    private function fetchProduct($id) {
        return $this->getConnection()->call(self::BASEURL."/items/$id");
    }

    /**
     * @param $productData
     * @return Product
     */
    private function buildProduct($productData): Product {
        $pictures = [];
        foreach ($productData->pictures as $picture) {
            $pictures[] = $picture->url;
        }
        $product = new Product($productData, $pictures);
        return $product;
    }

    private function getAuth() : Auth {
        return $this->auth;
    }
}
