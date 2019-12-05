<?php


namespace App\Meli\Products;


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
                new Settings(), new Connection()),
            new Storage()
        );
    }

    public function customBuild() {
        if (empty($this->connection) || empty($this->settings) || empty($this->storage)) {
            throw new \Exception('This method requires you to initialize storage, settings and connection before building, you may want to use defaultBuild');
        }
        return new ProductsManager(new ProductsFetcher(
            $this->settings, $this->connection),
            $this->storage
        );
    }
}
