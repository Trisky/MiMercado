<?php


namespace App\Meli;


use Throwable;

class UnauthorizedException extends \Exception
{

    /**
     * UnauthorizedException constructor.
     *
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null) {

    }
}
