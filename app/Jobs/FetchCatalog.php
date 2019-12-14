<?php

namespace App\Jobs;

use App\Meli\Products\CatalogStatus;
use App\Meli\Products\ProductsManagerBuilder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchCatalog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 2; //max tries
    protected $username;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $username) {
        $this->username = $username;
    }


    /**
     * @param $username
     */
    public function handle() {
        $manager = (new ProductsManagerBuilder())->build();
        $username = strtoupper($this->username);
        try{
            $catalog = new CatalogStatus($username);
            $manager->fetchAndStoreProducts($username);
            $catalog->setLoaded();
        }catch (\Exception $e){
            $catalog->setNotAvailable();
            throw new \Exception('Failed to fetch catalog'.$e->getMessage(),$e->getCode(),$e);
        }

    }
}
