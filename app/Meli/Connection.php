<?php


namespace App\Meli;


use GuzzleHttp\Exception\ClientException;

class Connection
{
    /**
     * @param $url
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function call($url) {
        $client = new \GuzzleHttp\Client();
        try{
            $response = $client->request('GET', $url);
            return json_decode($response->getBody());
        }catch(ClientException $e){
            $response = $e->getResponse();
            throw new \Exception('Error while trying to fetch products: '.$response->getReasonPhrase(),$response->getStatusCode(),$e);
        }
    }

    public function callWithToken($url){
        $accessToken = (new Auth())->getAccessToken();
        $url = $url . "?access_token=$accessToken";
        return $this->call($url);
    }
}
