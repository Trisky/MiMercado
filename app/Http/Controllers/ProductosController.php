<?php

namespace App\Http\Controllers;

use App\Meli\Auth;
use app\Meli\NoAccessDataException;
use App\Meli\Products\ProductsFetcher;
use App\Meli\Products\ProductsManager;
use App\Meli\Products\ProductsManagerBuilder;
use App\Meli\Products\Storage;
use App\Meli\UnauthorizedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis as RedisClient;


//private search by seller id https://developers.mercadolibre.com/en_us/search-products-seller
class ProductosController extends Controller
{
    public function clearCache(Request $request) {
        $username = $request->route('username');
        if(empty($username)){
            throw new \Exception('should provide a username to clean its data ex: /clear/john');
        }
        (new Auth())->clearCache($username);
        (new Storage())->clearCache($username);
        return view('cacheCleared');
    }

    public function apiProducts(Request $request){
        try{
            $username = $request->route('username');
            if(empty($username)){
                throw new \Exception('username must be provided for the listing of the products');
            }
            $auth = new Auth();
            $manager = (new ProductsManagerBuilder())->build();
            return $manager->getUserProducts($username);
        }catch (NoAccessDataException $e){
            return redirect('/notexist');
        }catch (UnauthorizedException $e){
            return redirect('/unauthorized');
        }
    }

}
