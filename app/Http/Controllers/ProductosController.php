<?php

namespace App\Http\Controllers;

use App\Meli\Auth;
use app\Meli\NoAccessDataException;
use App\Meli\Products\ProductsFetcher;
use App\Meli\Products\ProductsManager;
use App\Meli\Products\Storage;
use Illuminate\Http\Request;


//private search by seller id https://developers.mercadolibre.com/en_us/search-products-seller
class ProductosController extends Controller
{
    public function clearCache(Request $request) {
        (new Storage())->clearCache();
        (new Auth())->clearCache();
        return view('cacheCleared');
    }

    public function apiProducts(Request $request){
        try{
            return ProductsManager::getInstance()->getUserProducts();
        }catch (NoAccessDataException $e){
            return redirect('/wantlogin');
        }
    }

}
