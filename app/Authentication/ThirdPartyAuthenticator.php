<?php


namespace App\Authentication;
use App\Storage\Dummy\DummyCatalog;
use App\User;
use Illuminate\Support\Facades\Auth as LaravelAuth;
use Illuminate\Support\Facades\Hash;

class ThirdPartyAuthenticator
{

    public function authenticate(string $username) {
        if(LaravelAuth::check()){
            LaravelAuth::logout();
        }
        $user = User::where('name',$username)->first();
        if(!$user){
            $id = $this->registerAndGetId($username);
        }else{
            $id = $user->id;
        }

        LaravelAuth::loginUsingId($id,false);

    }

    public function authenticateAsDummyUser(){
        $this->authenticate(DummyCatalog::DUMMY_USER);
    }

    private function registerAndGetId(string $username) {
        $randomPass = str_random(12);
        $randomEmail = str_random(5);
        $user = User::create([
            'name' => $username,
            'email' => "noemail_$randomEmail@test.com",
            'password' => Hash::make($randomPass),
        ]);
        return $user->id;

    }

}
