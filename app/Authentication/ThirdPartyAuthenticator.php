<?php


namespace App\Authentication;
use App\User;
use Illuminate\Support\Facades\Auth as LaravelAuth;
use Illuminate\Support\Facades\Hash;

class ThirdPartyAuthenticator
{

    public function authenticate(string $username) {
        if(LaravelAuth::check()){
            LaravelAuth::logout();
        }
        $user = User::find('name',$username);
        if(!$user){
            $id = $this->registerAndGetId($username);
        }else{
            $id = $user->id;
        }

        LaravelAuth::loginUsingId($id,false);

    }

    private function registerAndGetId(string $username) {
        $randomPass = str_random(12);
        $user = User::create([
            'name' => $username,
            'email' => null,
            'password' => Hash::make($randomPass),
        ]);
        return $user->id;

    }

}
