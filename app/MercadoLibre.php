<?php
/**
 * Created by PhpStorm.
 * User: Trisky
 * Date: 8/6/2018
 * Time: 1:12 AM
 */

namespace App;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Redis;



class MercadoLibre
{
    CONST CACHE_KEY = 'products';

    private $username;
    private $client_id;
    private $app_id;
    private $app_secret;



    function __construct()
    {
        $this->username = env('MELI_USERNAME');
        $this->client_id = env('MELI_USERID');
        $this->app_id = env('MELI_APP_ID');
        $this->app_secret = env('MELI_SECRET');
        $this->app_url = env('APP_URL');
    }
    #region getters and setters
    /**
     * @return mixed
     */
    public function getAppUrl() {
        return $this->app_url;
    }

    /**
     * @return mixed
     */
    public function getAppId() {
        return $this->app_id;
    }
    /**
     * @return mixed
     */
    public function getAppSecret() {
        return $this->app_secret;
    }
    #endregion

    function getPublicProducts(){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', "https://api.mercadolibre.com/sites/MLA/search?nickname=$this->username");
        $response = json_decode($res->getBody());
        $products = $response->results;
        return $products;
    }

    public function clearCache(){
        Redis::del(self::CACHE_KEY);
        Redis::del(Auth::CACHE_KEY);
    }

    /**
     * Devuelve los productos del usuario. forEach de queries, bastante lenteja.
     * @return array
     */
    public function getUserProducts(){
        $products = [];
        if(!($responses = json_decode(Redis::get(self::CACHE_KEY)))){
            $responses = $this->fetchPrivateProducts($responses);
            Redis::setex(self::CACHE_KEY, 60 * 60 * 24, json_encode($responses));
        }

        foreach ($responses as $response){
            $products[] =new Product(1,$response,$response->description);
        }
        return $products;
    }

    private function fetchItemDescription($id){
        $url = "https://api.mercadolibre.com/items/$id/description";
        return $this->getBody($url)->plain_text;
    }

    private function getBody($url,$addToken = false) {
        if($addToken) {
            $accessToken = (new Auth())->getAccessToken();
            $url = $url . "?access_token=$accessToken";
        }
        $client = new \GuzzleHttp\Client();
        try{
            $response = $client->request('GET', $url);
        }catch(ClientException $e){
            $response = $e->getResponse();
            throw new \Exception('Error while trying to fetch products: '.$response->getReasonPhrase(),$response->getStatusCode(),$e);
        }

        $response = json_decode($response->getBody());
        return $response;
    }

    /**
     * @param $responses
     * @return array
     */
    public function fetchPrivateProducts($responses) {
        if(empty($this->client_id)){
            throw new \Exception('MELI_USERID is not set in the .env file.');
        }
        $response1 = $this->getBody("https://api.mercadolibre.com/users/$this->client_id/items/search", true);
        $articleIds = $response1->results;

        foreach ($articleIds as $id) {
            $response = $this->getBody("https://api.mercadolibre.com/items/$id");
            $response->description = $this->fetchItemDescription($id);
            $responses[] = $response;
        }
        return $responses;
    }
}
