<?php


namespace App\Storage;

use Illuminate\Support\Facades\Redis as RedisClient;

class Redis
{
    static public function saveForUser($data,$key,$username){
        $keyWithUsername = self::buildKey($key,$username);
        RedisClient::setex($keyWithUsername, self::getDefaultTime(), json_encode($data));
    }

    static public function getFromUser($key,$username){
        $keyWithUsername = self::buildKey($key,$username);
        $accessData = RedisClient::get($keyWithUsername);
        return json_decode($accessData);
    }

    public static function delete(string $key,string $username) {
        RedisClient::del(self::buildKey($key,$username));
    }

    /**
     * @return float|int
     */
    private static function getDefaultTime():int {
        return 60 * 60 * 24;
    }

    private static function buildKey(string $key, string $username): string {
        $username = strtoupper($username);
        return $username . ':' . $key;
    }



}
