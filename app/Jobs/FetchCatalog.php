<?php

namespace App\Jobs;

use App\Meli\Products\CatalogStatus;
use App\Meli\Products\ProductsManagerBuilder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
        $username = strtoupper($this->username);
        $this->validate($username);
        $manager = (new ProductsManagerBuilder())->build();
        $catalog = new CatalogStatus($username);
        if($catalog->isLoading()){
            Log::info("Catalog for the user $username is loading, this job will be skipped.");
            return;
        }
        $catalog->setLoading();
        try{
            $manager->fetchAndStoreProducts($username);
            $catalog->setLoaded();
        }catch (\Exception $e){
            $catalog->setNotAvailable();
            throw new \Exception('Failed to fetch catalog'.$e->getMessage(),$e->getCode(),$e);
        }
    }

    /**
     * @param string $username
     * @throws \Exception
     */
    private function validate(string $username): void {
        if (empty($username)) {
            throw new \Exception('Catalog fetch requires a username but none was provided');
        }
    }
}
