<?php


namespace App\Meli\Products;


use App\Storage\Redis;

class CatalogStatus
{
    private $username;

    public function __construct($username) {
        $this->username = $username;
    }

    CONST LOADED = 'loaded';
    CONST WAITING = 'waiting'; //we're waiting for whe job to run and finish.
    CONST NOTFOUND = 'notfound';

    CONST KEY = 'catalog_status';

    public function getCatalogStatus(){
        $status = Redis::getFromUser(self::KEY,$this->username);
        return $this->getStatuses()[$status] ?? self::NOTFOUND;
    }

    public function setWaiting(){
        $this->setStatus(self::WAITING);
    }
    public function setLoaded(){
        $this->setStatus(self::LOADED);
    }
    public function setNotFound(){
        $this->setStatus(self::NOTFOUND);
    }

    private function getStatuses(){
        return [
            self::LOADED => self::LOADED,
            self::WAITING => self::WAITING,
            self::NOTFOUND => self::NOTFOUND
        ];
    }

    private function setStatus(string $status) {
        Redis::saveForUser($status,self::KEY,$this->username);
    }
}