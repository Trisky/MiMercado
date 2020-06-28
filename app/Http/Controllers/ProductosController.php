<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Products\AProductsController;
use App\Meli\Auth;

use App\Meli\Products\Storage;
use Illuminate\Http\Request;


//private search by seller id https://developers.mercadolibre.com/en_us/search-products-seller
class ProductosController extends AProductsController
{

    public function clearCache(Request $request) {
        $username = $request->route('username');
        if(empty($username)){
            throw new \Exception('should provide a username to clean its data ex: /clear/john');
        }
        (new Auth())->clearCache($username);
        (new Storage())->clearCache($username);
        return view('meliAuth/cacheCleared');
    }

    public function apiProducts(Request $request){
        $username = $request->route('username');
        if(empty($username)){
            throw new \Exception('username must be provided for the listing of the products');
        }
        return $this->fetchProducts($username);
    }

}
