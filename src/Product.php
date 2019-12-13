<?php

namespace App;

use App\Promo\Promo;

class Product
{
    protected $id = 0;
    protected $name;
    protected $quantity = 0;
    protected $price;

    public function __construct($name, $price = 0)
    {
        $this->id = uniqid();
        $this->name = $name;
        $this->price = $price;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @param $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return (int) $this->quantity;
    }
}