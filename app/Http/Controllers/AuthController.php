<?php


namespace App\Http\Controllers;

use App\Meli\Settings;
use Illuminate\Http\Request;
use App\Meli\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $appId = (new Settings())->getAppId();
        return redirect($url = "https://auth.mercadolibre.com.ar/authorization?response_type=code&client_id=$appId");
    }

    /**
     * This is where the browser is redirected after the user  successfully enters the credentials in Mercado Libre
     * @param Request $request
     * @throws \Exception
     */
    public function redirectCallback(Request $request){
        $authCode = $request->input('code');
        if(empty($authCode)){
            throw new \Exception('No auth code received');
        }
        $username = (new Auth())->fetchAndStoreAccessToken($authCode);

        return redirect("/app/catalog/$username");
    }
}
