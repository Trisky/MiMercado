<?php


namespace App\Storage\Dummy;


use App\Meli\Auth;
use App\Meli\Products\CatalogStatus;
use App\Meli\Products\Storage;

class DummyCatalog
{
    CONST DUMMY_USER = 'dummy_user';

    const VALID_KEYS = [
        CatalogStatus::KEY,
        Auth::CACHE_KEY,
        Storage::CACHE_KEY
    ];
    public function get(string $key){
        if(!in_array($key,self::VALID_KEYS)){
            throw new \Exception('this key is not valid for the dummy user');
        }
        try{
            $content = file_get_contents(app_path()."/Storage/Dummy/dummy_$key.json");
        }catch (\Exception $e){
            throw new \Exception("Failed to load dummy data for $key",$e->getCode(),$e);
        }

        if(empty($content)){
            throw new \Exception("JSON dummy content could not be loaded for key: $key");
        }
        return $content;
    }

}
