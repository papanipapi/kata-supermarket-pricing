<?php

namespace App;

class Store
{
    protected $products;

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $this->products[$product->getId()] = $product;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param $id
     * @return Product|null
     */
    public function getProductById($id)
    {
        $products = $this->getProducts();
        return isset($products[$id]) ? $products[$id] : null;
    }

    /**
     * @param $id
     * @return int
     */
    public function getRemainingProductById($id)
    {
        $product = $this->getProductById($id);
        return $product->getQuantity();
    }

    /**
     * @param $id
     * @param $quantity
     */
    public function deductQuantityByProductId($id, $quantity)
    {
        $product = $this->getProductById($id);
        $updatedQuantity = $product->getQuantity() - $quantity;
        $product->setQuantity($updatedQuantity);
        $this->products[$id] = $product;
    }
}