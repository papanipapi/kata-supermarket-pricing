<?php

namespace App\Promo;

use App\Cart;

class Promo
{
    protected $cart;
    protected $discount = 0;

    /**
     * @param Cart $cart
     */
    public function apply(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return int
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @return \App\Product[]
     */
    public function getItems()
    {
        return $this->getCart()->getItems();
    }

    /**
     * @param $items
     */
    public function updateItems($items)
    {
        return $this->getCart()->updateItems($items);
    }
}