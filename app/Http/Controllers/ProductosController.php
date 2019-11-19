<?php

namespace App\Http\Controllers;

use App\MercadoLibre;
use Illuminate\Http\Request;
//private search by seller id https://developers.mercadolibre.com/en_us/search-products-seller
class ProductosController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $meli = new MercadoLibre();
        $products = $meli->getUserProducts();
        return view('products', ['products' =>$products]);
    }

    public function clearCache(Request $request){
        $meli = new MercadoLibre();
        $meli->clearCache();
        return view('cacheCleared');
    }

}
