<?php


namespace App\Meli\Products;


use App\Meli\Auth;
use App\Meli\Connection;
use App\Meli\Settings;

class ProductsManagerBuilder
{
    private $storage;
    private $settings;
    private $connection;

    public function setStorage($storage){
        $this->storage = $storage;
    }
    public function setSettings($settings){
        $this->settings = $settings;
    }
    public function setConnection($connection){
        $this->connection = $connection;
    }

    public function build(){
        return new ProductsManager(
            new ProductsFetcher(
                new Settings(), new Connection(),new Auth()),
            new Storage()
        );
    }
}
