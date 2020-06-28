<?php


namespace App\Meli;


use App\Storage\Redis;
use Predis\Connection\ConnectionException;

class Auth
{
    const CACHE_KEY = 'auth_key';

    public function fetchAndStoreAccessToken(string $authCode){

        $userAuthentication = $this->fetchUserAuthentication($authCode);
        try{
            $accessToken =  $userAuthentication->access_token;
            $userId = $userAuthentication->user_id;
            $username = $this->fetchUsername($userId);
        }catch (\Exception $e){
            throw new \Exception("Failed to get userId, username and access token from response: $userAuthentication");
        }
        if(empty($accessToken) || empty($userId)){
            throw new \Exception('Access token not received');
        }
        $this->saveAccessToken($userAuthentication,$username);
        return $username;
    }
    public function saveAccessToken( $response,$username){
        Redis::saveForUser($response,self::CACHE_KEY,$username,Redis::ONE_MONTH);
    }

    /**
     * Fetches the access token if its expired gets a new one
     * @return string
     * @throws \Exception
     */
    public function getAccessToken($username){
        $accessData = $this->getAccessData($username);
        return (string) $accessData->access_token;
    }

    public function getUserId($username){
        $accessData = $this->getAccessData($username);
        return (string) $accessData->user_id;
    }

    public function clearCache($username){
        try{
            Redis::delete(self::CACHE_KEY,$username);
        }catch (ConnectionException $e){
            throw new \Exception('Failed to connect to redis. Is the service running and the env data correct?',$e->getCode(),$e);
        }
    }

    /**
     * @return mixed
     * @throws NoAccessDataException
     */
    private function getAccessData($username) {
        if(!empty($this->accessData[$username])){
            return $this->accessData[$username];
        }
        $accessData = Redis::getFromUser(self::CACHE_KEY,$username);
        if (empty($accessData)) {
            throw new NoAccessDataException();
        }
        $date = time();
        if($date>($date+$accessData->expires_in)){
            $token = $accessData->refresh_token;
            $accessData = $this->fetchAndStoreAccessToken($token);
        }
        $this->accessData[$username] = $accessData;
        return $this->accessData[$username];
    }

    /**
     * @param string $authCode
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function fetchUserAuthentication(string $authCode) {
        $settings = new Settings();
        $appId = $settings->getAppId();
        $secret = $settings->getAppSecret();
        $appUrl = $settings->getAppUrl() . '/loginredirect.php';

        $url = "https://api.mercadolibre.com/oauth/token?grant_type=authorization_code&client_id=$appId&client_secret=$secret&code=$authCode&redirect_uri=$appUrl";
        $client = new \GuzzleHttp\Client();
        try {
            $res = $client->request('POST', $url);
        } catch (\Exception $e) {
            throw new \Exception("Failed to retrieve the access_token from $url " . $e->getMessage(), $e->getCode(), $e);
        }
        $body = $res->getBody();
        $response = json_decode($body);
        return $response;
    }

    private function fetchUsername(int $userId) :string{
        $url = 'https://api.mercadolibre.com/users/'.$userId;
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url)->getBody();
        return json_decode($res)->nickname;
    }
}
