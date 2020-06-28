<?php


namespace App\Http\Controllers\Admin;


use App\Authentication\ThirdPartyAuthenticator;
use App\Http\Controllers\Products\AProductsController;
use App\Meli\Auth;
use App\Storage\Dummy\DummyCatalog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth as LaravelAuth;

class AdminProductsController extends AProductsController
{
    public function apiProducts(Request $request) {
        if (!LaravelAuth::check()) {
            $username = $request->route('username');
            if ($username == DummyCatalog::DUMMY_USER) {
                (new ThirdPartyAuthenticator())->authenticateAsDummyUser();
            } else {
                return response('not auth', Response::HTTP_UNAUTHORIZED);
            }
        }
        $username = LaravelAuth::user()->name;
        if (empty($username)) {
            throw new \Exception('username must be provided for the listing of the products');
        }
        return $this->fetchProducts($username, false);
    }
}
