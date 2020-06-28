<?php


namespace App\Http\Controllers\Products;


use App\Http\Controllers\Controller;
use app\Meli\NoAccessDataException;
use App\Meli\Products\CatalogNotReadyYet;
use App\Meli\Products\CatalogStatus;
use App\Meli\Products\ProductsManagerBuilder;
use App\Meli\UnauthorizedException;

class AProductsController extends Controller
{
    protected function fetchProducts(string $username,bool $showOnlyVisible = true) {
        try {
            $manager = (new ProductsManagerBuilder())->build();
            return ['products' => $manager->getUserProducts($username, $showOnlyVisible), 'status' => 'success'];
        } catch (NoAccessDataException $e) {
            return view('meliAuth/notexist');
        } catch (UnauthorizedException $e) {
            return ['products' => [], 'status' => CatalogStatus::NOTAVALILABLE];
        } catch (CatalogNotReadyYet $e) {
            return ['products' => [], 'status' => CatalogStatus::WAITING];
        }
    }
}
