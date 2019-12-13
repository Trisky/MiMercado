<?php


namespace App\Meli\Products;


class CatalogNotReadyYet extends \Exception
{

    /**
     * CatalogNotReadyYet constructor.
     */
    public function __construct($username) {
        parent::__construct('The catalog from the user '.$username.' is still being retrieved from Mercado Libre');
    }
}
