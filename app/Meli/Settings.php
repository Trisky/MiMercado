<?php


namespace App\Meli;


class Settings
{

    private $username;
    private $user_id;
    private $app_id;
    private $app_secret;
    private $app_url;



    function __construct()
    {
        $this->username = env('MELI_USERNAME');
        $this->user_id = env('MELI_USERID');
        $this->app_id = env('MELI_APP_ID');
        $this->app_secret = env('MELI_SECRET');
        $this->app_url = env('APP_URL');
    }

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getAppId() {
        return $this->app_id;
    }

    /**
     * @return mixed
     */
    public function getAppSecret() {
        return $this->app_secret;
    }

    /**
     * @return mixed
     */
    public function getAppUrl() {
        return $this->app_url;
    }


}
