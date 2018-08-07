<?php
/**
 * Created by PhpStorm.
 * User: Trisky
 * Date: 8/6/2018
 * Time: 10:35 PM
 */

namespace App;


class Product {


    private $pictures;
    private $title;
    private $condition;
    private $permaLink;
    private $id;
    private $description;
    private $price;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getPictures() {
        return $this->pictures;
    }


    /**
     * @return mixed
     */
    public function getCondition() {
        return $this->condition;
    }

    /**
     * @return mixed
     */
    public function getPermaLink() {
        return $this->permaLink;
    }

    /**
     * @return mixed
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    function __construct($id,$res,$description) {
        $this->id = $id;
        $this->title = $res->title;
        $this->price = $res->price;
        $this->condition = $res->condition;
        $this->permaLink = $res->permalink;
        $this->description = $description;
        foreach ($res->pictures as $picture){
            $this->addPicture($picture->url);
        }
    }
    private function addPicture($picture){
        $this->pictures[] = $picture;
    }

    public function toJSON(){
        $a['id'] = $this->getId();
        $a['title'] = $this->getTitle();
        $a['price'] = $this->getPrice();
        $a['permaLink'] = $this->getPermaLink();
        $a['description'] = $this->getDescription();
        $a['pictures'] = $this->getPictures();
        return json_encode($a);
    }
}
