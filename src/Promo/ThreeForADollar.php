<?php

namespace App\Promo;

use App\Cart;

class ThreeForADollar extends Promo
{
    const DIVISOR = 3;
    const PRICE = 1;

    /**
     * @param Cart $cart
     */
    public function apply(Cart $cart)
    {
        parent::apply($cart); // TODO: Change the autogenerated stub

        $discount = 0;
        foreach ($cart->getItems() as $item) {
            $numOfDivisible = floor($item->getQuantity() / self::DIVISOR);
            $discount += $numOfDivisible * ((self::DIVISOR * $item->getPrice()) - self::PRICE);
        }
        $this->setDiscount($discount);
    }
}