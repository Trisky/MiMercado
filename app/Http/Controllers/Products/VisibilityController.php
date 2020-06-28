<?php


namespace App\Http\Controllers\Products;


use App\Http\Controllers\Controller;
use App\Product as Product;
use Illuminate\Http\Request;

class VisibilityController  extends Controller
{
    public function show(Request $request){
        $productId = $request->route('product_id');
        $product = $this->fetchProduct($productId);
        $product->visible = 1;
        $product->save();

    }
    public function hide(Request $request){
        $productId = $request->route('product_id');
        $product = $this->fetchProduct($productId);
        $product->visible = 0;
        $product->save();
    }

    private function fetchProduct($productId) : Product{
       $product =  Product::where('product_id', $productId)->first();
       if(empty($product)){
           $product = new Product();
           $product->product_id = $productId;
           $product->username = 'dummy_user';//TODO
       }
       return $product;
    }

}
