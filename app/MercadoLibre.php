<?php
/**
 * Created by PhpStorm.
 * User: Trisky
 * Date: 8/6/2018
 * Time: 1:12 AM
 */

namespace App;
use Illuminate\Support\Facades\Redis;



class MercadoLibre
{
    CONST CACHE_KEY = 'products';

    private $username;
    private $access_token;
    private $client_id;

    function __construct()
    {
        $this->username = env('MELI_USERNAME');
        $this->client_id = env('MELI_USERID');
        $this->access_token = env('MELI_ACCESSTOKEN');
        $secret = env('MELI_SECRET');
    }

    function getPublicProducts(){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', "https://api.mercadolibre.com/sites/MLA/search?nickname=$this->username");
        $response = json_decode($res->getBody());
        $products = $response->results;
        return $products;
    }



    public function clearCache(){
        Redis::del(self::CACHE_KEY);
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
        if($addToken){
            $url= $url."?access_token=$this->access_token";
        }
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        $response = json_decode($response->getBody());
        return $response;
    }

    /**
     * @param $responses
     * @return array
     */
    public function fetchPrivateProducts($responses) {
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
