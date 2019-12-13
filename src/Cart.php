<?php

namespace App;

use App\Product;
use App\Promo\Promo;

class Cart
{
    protected $items;
    protected $promo;
    protected $discount = 0;
    protected $subtotal = 0;

    /**
     * @param Product $product
     * @param $quantity
     */
    public function add(Product $product, $quantity)
    {
        $product->setQuantity($quantity);
        $this->items[] = $product;
        $this->calculate();
    }

    /**
     * @return Product[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return float|int
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * @param $subtotal
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    }

    /**
     * @codeCoverageIgnore
     */
    public function calculate()
    {
        $this->calculateSubtotal();
    }

    /**
     * @codeCoverageIgnore
     */
    public function calculateSubtotal()
    {
        $subtotal = 0;
        foreach ($this->getItems() as $item) {
            $subtotal += $item->getPrice() * $item->getQuantity();
        }
        $subtotal -= $this->getDiscount();
        $this->setSubtotal($subtotal);
    }

    /**
     * @param Promo $promo
     */
    public function applyPromo(Promo $promo)
    {
        $this->promo = $promo;
        $this->promo->apply($this);
        $this->setDiscount($this->promo->getDiscount());
        $this->updateItems($this->promo->getItems());
        $this->calculate();
    }

    /**
     * @param $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * @return int
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param $items
     */
    public function updateItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return int
     */
    public function getItemsCount()
    {
        $count = 0;
        foreach ($this->getItems() as $item) {
            $count += $item->getQuantity();
        }
        return $count;
    }
}