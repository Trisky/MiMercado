<?php


namespace App\Http\Controllers\Products;


use App\Http\Controllers\Controller;
use App\Product as Product;
use Illuminate\Http\Request;

class VisibilityController  extends Controller
{
    public function showProduct(Request $request){
        $productId = $request->input('product_id');
        $product = $this->fetchProduct($productId);
        $product->show()->save();

    }
    public function hideProduct(Request $request){
        $productId = $request->input('product_id');
        $product = $this->fetchProduct($productId);
        $product->hide()->save();
    }

    private function fetchProduct($productId) : Product{
       $product =  Product::where('product_id', $productId)->first();
       if(empty($product)){
           $product = new Product();
           $product->product_id = $productId;
           $product->user = 'SEBA2321';//TODO
       }
       return $product;
    }

}
