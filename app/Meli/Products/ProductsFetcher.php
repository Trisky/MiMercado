<?php


namespace App\Meli\Products;


use App\Meli\Auth;
use App\Meli\Connection;
use App\Meli\Settings;
use GuzzleHttp\Exception\ClientException;

class ProductsFetcher
{
    CONST BASEURL = "https://api.mercadolibre.com";

    private $settings;
    private $connection;

    /**
     * @return Connection
     */
    private function getConnection(): Connection {
        return $this->connection;
    }

    public function __construct(Settings $settings,Connection $connection) {
        $this->connection = $connection;
        $this->settings = $settings;
    }

    /**
     * @param $responses
     * @return array
     */
    public function fetchPrivateProducts() {
        $products = [];
        $clientId = $this->getSettings()->getUserId();
        if(empty($clientId)){
            throw new \Exception('MELI_USERID is not set in the .env file.');
        }
        $response = $this->getConnection()->callWithToken(self::BASEURL."/users/$clientId/items/search");
        $products = $this->parseProductsFromResponseAndFetchDescriptions($response, $products);
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
    private function parseProductsFromResponseAndFetchDescriptions($productsResponse, array $products): array {
        $articleIds = $productsResponse->results;
        foreach ($articleIds as $articleId) {
            $productData = $this->fetchProduct($articleId);
            $productData->description  = $this->fetchProductDescription($articleId);
            $products[] = new Product(0, $productData);
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
}
