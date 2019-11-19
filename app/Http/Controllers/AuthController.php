<?php


namespace App\Http\Controllers;


use App\MercadoLibre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $meli = new MercadoLibre();
        $meli->clearCache();
        $appId = $meli->getAppId();
        return redirect($url = "https://auth.mercadolibre.com.ar/authorization?response_type=code&client_id=$appId");
    }

    public function redirectCallback(Request $request){
        $authCode = $request->input('code');
        if(empty($authCode)){
            throw new \Exception('No auth code received');
        }
        (new Auth())->fetchAndStoreAccessToken($authCode);
        return redirect('/');
    }

    public function wantLogIn(Request $request){
        view('wantlogin');
    }
}
