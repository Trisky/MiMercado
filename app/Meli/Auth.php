<?php


namespace App\Meli;


use Illuminate\Support\Facades\Redis;

class Auth
{
    const CACHE_KEY = 'auth_key';

    public function fetchAndStoreAccessToken(string $authCode){
        $settings = new Settings();
        $appId = $settings->getAppId();
        $secret = $settings->getAppSecret();
        $appUrl = $settings->getAppUrl().'/loginredirect.php';

        $url = "https://api.mercadolibre.com/oauth/token?grant_type=authorization_code&client_id=$appId&client_secret=$secret&code=$authCode&redirect_uri=$appUrl";
        $client = new \GuzzleHttp\Client();
        try{
            $res = $client->request('POST', $url);
        }catch (\Exception $e){
            throw new \Exception("Failed to retrieve the access_token from $url ".$e->getMessage(),$e->getCode(),$e);
        }
        $response = json_decode($res->getBody());
        $accessToken =  $response->access_token?? null;

        if(empty($accessToken)){
            throw new \Exception('Access token not received');
        }
        $this->saveAccessToken($response);
        return $response;
    }
    public function saveAccessToken( $response){
        Redis::setex(self::CACHE_KEY, 60 * 60 * 24, json_encode($response));
    }

    /**
     * Fetches the access token if its expired gets a new one
     * @return string
     * @throws \Exception
     */
    public function getAccessToken(){
        $accessData = Redis::get(self::CACHE_KEY);
        $accessData = json_decode($accessData);
        $date = time();
        if(empty($accessData)){
            throw new NoAccessDataException();
        }
        if($date>($date+$accessData->expires_in)){
            $token = $accessData->refresh_token;
            $accessData = $this->fetchAndStoreAccessToken($token);
        }
        return (string) $accessData->access_token;
    }

    public function clearCache(){
        Redis::del(self::CACHE_KEY);
    }
}
