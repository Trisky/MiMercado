<?php
/**
 * Created by PhpStorm.
 * User: Trisky
 * Date: 8/6/2018
 * Time: 10:35 PM
 */

namespace App\Meli\Products;


class Product implements \JsonSerializable {


    private $pictures;
    private $title;
    private $condition;
    private $permaLink;
    private $id;
    private $description;
    private $price;
    private $visible = true;


    public function setVisible($visible){
        $this->visible = (bool) $visible;
    }

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

    public function getShortDescription(){
        return substr($this->getDescription(),0,120).'...';
    }

    /**
     * @return mixed
     */
    public function getPictures() {
        return $this->pictures;
    }

    public function getFirstpicture(){
        return reset($this->pictures);
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

    function __construct($res,$pictures) {
        $this->id = $res->id;
        $this->title = $res->title;
        $this->price = $res->price;
        $this->condition = $res->condition;
        $this->permaLink = $res->permalink;
        $this->description = $res->description;
        foreach ($pictures as $picture){
            $this->addPicture($picture);
        }
    }

    private function addPicture($picture){
        $this->pictures[] = $picture;
    }

    public function getMeliId(){
        return $this->getId();
    }

    public function jsonSerialize() {
        return
            [
                'id' => $this->getId(),
                'title' => $this->getTitle(),
                'price' => $this->getPrice(),
                'permalink' => $this->getPermaLink(),
                'condition' => $this->getCondition(),
                'description' => $this->getDescription(),
                'pictures' => $this->getPictures(),
                'visible' => $this->isVisible()
            ];
    }

    public function isVisible() {
        return $this->visible;
    }
}
