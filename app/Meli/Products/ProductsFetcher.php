<?php


namespace App\Meli\Products;


use App\Meli\Auth;
use App\Meli\Settings;
use GuzzleHttp\Exception\ClientException;

class ProductsFetcher
{
    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Settings $settings) {
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
        $response1 = $this->callWithToken("https://api.mercadolibre.com/users/$clientId/items/search");
        $articleIds = $response1->results;

        foreach ($articleIds as $id) {
            $response = $this->call("https://api.mercadolibre.com/items/$id");
            $response->description = $this->fetchItemDescription($id);
            $products[] = new Product(0,$response);
        }
        return $products;
    }

    /**
     * @return Settings
     */
    private function getSettings(): Settings {
        return $this->settings;
    }

    private function callWithToken($url){
        $accessToken = (new Auth())->getAccessToken();
        $url = $url . "?access_token=$accessToken";
        return $this->call($url);
    }

    private function call($url) {
        $client = new \GuzzleHttp\Client();
        try{
            $response = $client->request('GET', $url);
            return json_decode($response->getBody());
        }catch(ClientException $e){
            $response = $e->getResponse();
            throw new \Exception('Error while trying to fetch products: '.$response->getReasonPhrase(),$response->getStatusCode(),$e);
        }
    }

    private function fetchItemDescription($id){
        $url = "https://api.mercadolibre.com/items/$id/description";
        return $this->call($url)->plain_text;
    }
}
