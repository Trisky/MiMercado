<?php
/**
 * Created by PhpStorm.
 * User: Trisky
 * Date: 8/6/2018
 * Time: 1:12 AM
 */

namespace App;


class MercadoLibre
{
    CONST API_GET_DESCRIPTION = 'https://api.mercadolibre.com/items/';
    CONST API_GET_DESCRIPTION2 = '/description';

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

    /**
     * Devuelve los productos del usuario. forEach de queries, bastante lenteja.
     * @return array
     */
    function fetchPrivateProducts(){
        $response = $this->getBody("https://api.mercadolibre.com/users/$this->client_id/items/search",true);
        $articleIds = $response->results;
        $products = [];
        foreach ($articleIds as $id){
            $response = $this->getBody("https://api.mercadolibre.com/items/$id");
            $description = $this->fetchItemDescription($id);
            $products[] =new Product($id,$response,$description);
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
//        if(is_null($response['body'])){
//            throw new \Exception('Error on meli api call, body null');
//        }
        return $response;
    }
}
