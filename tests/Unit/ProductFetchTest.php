<?php

namespace Tests\Unit;

use App\Meli\Connection;
use App\Meli\Products\Product;
use App\Meli\Products\ProductsFetcher;
use App\Meli\Products\ProductsManager;
use App\Meli\Settings;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductFetchTest extends TestCase
{
    private $settings;
    private $connection;
    public function setUp():void {
        parent::setUp();
        $path = base_path().'/tests/Unit/';
        $connection = Mockery::mock(Connection::class);
        $settings = Mockery::mock(Settings::class);
        $jsonUserProducts = json_decode(file_get_contents($path.'userProducts.json'));
        $jsonProduct = json_decode(file_get_contents($path.'product.json'));
        $jsonDescription = json_decode(file_get_contents( $path.'description.json'));

        $id = 'MLA789086032';
        $userId = 1234;
        $connection->allows()
            ->call(ProductsFetcher::BASEURL."/items/$id/description")
            ->andReturn($jsonDescription);
        $connection->allows()
            ->call(ProductsFetcher::BASEURL."/items/$id")
            ->andReturn($jsonProduct);
        $connection->allows()
            ->callWithToken(ProductsFetcher::BASEURL."/users/$userId/items/search")
            ->andReturn($jsonUserProducts);

        $settings->allows()
            ->getUserId()
            ->andReturn($userId);

        $this->connection = $connection;
        $this->settings = $settings;

    }

    /** @test */
    public function fetchTest()
    {
        $fetcher = new ProductsFetcher($this->settings,$this->connection);
        $products = $fetcher->fetchPrivateProducts();
        $this->assertTrue(count($products)==1);
        $product = current($products);
        /** @var $product Product */
        $this->assertTrue($product->getPrice() == 30000);
        $this->assertTrue($product->getCondition() == 'used');
        $this->assertTrue($product->getTitle() =="Computadora Gamer - 1060 6gb - Super Compacta!");
    }
}
