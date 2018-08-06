<?php
/**
 * Created by PhpStorm.
 * User: Trisky
 * Date: 8/6/2018
 * Time: 1:12 AM
 */

namespace App;


class MercadoLibre //extends \Meli
{
    private $username;

    function __construct()
    {
        $this->username = env('MELI_USERNAME');
        $userId = env('MELI_USERID');
        $token = env('MELI_ACCESSTOKEN');
        $secret = env('MELI_SECRET');
        //parent::__construct($userId, $secret, $token, null);
    }

    function getPublicProducts(){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', "https://api.mercadolibre.com/sites/MLA/search?nickname=$this->username");
        $response = json_decode($res->getBody());
        $products = $response->results;
        return $products;
    }
}