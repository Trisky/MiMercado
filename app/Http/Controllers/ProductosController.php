<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//busqueda private by seller id https://developers.mercadolibre.com/en_us/search-products-seller
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
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://api.mercadolibre.com/sites/MLA/search?nickname=sebasnights');
        $seba2321 = '84686179';


        // '{"id": 1420053, "name": "guzzle", ...}'
        $response = json_decode($res->getBody());

        $meli = new \Meli('84686179');
        $products = $response->results;
        return view('productos', ['productos' =>$products]);
    }}
