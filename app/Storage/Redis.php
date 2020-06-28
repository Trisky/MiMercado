<?php


namespace App\Storage;

use App\Storage\Dummy\DummyCatalog;
use Illuminate\Support\Facades\Redis as RedisClient;

class Redis
{
    CONST ONE_DAY = 60 * 60 * 24;
    CONST ONE_WEEK = self::ONE_DAY * 7;
    CONST ONE_MONTH = self::ONE_WEEK * 4;

    static public function saveForUser($data,$key,$username,$time = self::ONE_DAY){
        $keyWithUsername = self::buildKey($key,$username);
        RedisClient::setex($keyWithUsername,$time, json_encode($data));
    }

    static public function getFromUser($key,$username){
        if($username == DummyCatalog::DUMMY_USER){
            $jsonString =  (new DummyCatalog())->get($key);
            return json_decode($jsonString);
        }
        $keyWithUsername = self::buildKey($key,$username);
        $accessData = RedisClient::get($keyWithUsername);
        return json_decode($accessData);
    }

    public static function delete(string $key,string $username) {
        RedisClient::del(self::buildKey($key,$username));
    }


    private static function buildKey(string $key, string $username): string {
        $username = strtoupper($username);
        return $username . ':' . $key;
    }



}
