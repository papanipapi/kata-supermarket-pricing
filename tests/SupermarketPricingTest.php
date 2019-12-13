<?php

use App\Product;
use App\Cart;
use App\Store;
use App\Promo\ThreeForADollar;
use App\Promo\BuyTwoGetOne;

class SupermarketPricingTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateNewProduct()
    {
        $product = new Product('Beans');
        $this->assertEquals('Beans', $product);
    }

    public function testCanSetPrice()
    {
        $product = new Product('Beans');
        $product->setPrice(.65);
        $this->assertEquals(.65, $product->getPrice());
    }

    public function testCanSetQuantity()
    {
        $product = new Product('Beans');
        $product->setQuantity(3);
        $this->assertEquals(3, $product->getQuantity());
    }

    public function testCanAddComplexPrice()
    {
        $product = new Product('Beans');
        $product->setPrice(.65);
        $cart = new Cart();

        $promo = new ThreeForADollar();
        $cart->add($product, 3);
        $cart->applyPromo($promo);
        $this->assertEquals(1, $cart->getSubtotal());
    }

    public function testCanAddTwoProduct()
    {
        $beans = new Product('Beans');
        $coffee = new Product('Coffee');
        $coffee->setPrice(4);
        $beans->setPrice(.65);
        $cart = new Cart();

        $promo = new ThreeForADollar();
        $cart->add($beans, 3);
        $cart->add($coffee, 6);
        $cart->applyPromo($promo);
        $this->assertEquals(3, $cart->getSubtotal());
    }

    public function testCanAddComplexPrice3()
    {
        $beans = new Product('Beans');
        $coffee = new Product('Coffee');
        $sugar = new Product('Sugar');
        $coffee->setPrice(4);
        $beans->setPrice(.65);
        $sugar->setPrice(.85);
        $cart = new Cart();

        $promo = new ThreeForADollar();
        $cart->add($beans, 3);
        $cart->add($coffee, 6);
        $cart->add($sugar, 7);
        $cart->applyPromo($promo);
        $this->assertEquals(5.85, $cart->getSubtotal());
    }

    public function testCanAddMoreComplexPrice()
    {
        $product = new Product('Beans');
        $product->setPrice(.65);
        $cart = new Cart();
        $promo = new ThreeForADollar();
        $cart->add($product, 7);
        $cart->applyPromo($promo);
        $this->assertEquals(2.65, $cart->getSubtotal());
    }

    public function testCanViewCheckout()
    {
        $product = new Product('Beans');
        $product->setPrice(.65);
        $cart = new Cart();
        $promo = new ThreeForADollar();
        $cart->add($product, 7);
        $this->assertEquals(4.55, $cart->getSubtotal());

        $cart->applyPromo($promo);
        $this->assertEquals(2.65, $cart->getSubtotal());
    }

    public function testCanMonitorStock()
    {
        $store = new Store();

        $productId = 123;

        $product = new Product('Beans');
        $product->setId($productId);
        $product->setPrice(.65);
        $product->setQuantity(10);

        $store->addProduct($product);
        $store->deductQuantityByProductId($product->getId(), 6);

        $this->assertEquals(4, $store->getRemainingProductById($product->getId()));
    }

    public function testCanHaveDiscount()
    {
        $product = new Product('Beans');
        $product->setPrice(.65);
        $cart = new Cart();
        $promo = new ThreeForADollar();
        $cart->add($product, 3);
        $cart->applyPromo($promo);
        $this->assertEquals(.95, $cart->getDiscount());
    }

    public function testCanHaveMoreDiscount()
    {
        $product = new Product('Beans');
        $product->setPrice(.65);
        $cart = new Cart();
        $promo = new ThreeForADollar();
        $cart->add($product, 7);
        $this->assertEquals(0, $cart->getDiscount());

        $cart->applyPromo($promo);
        $this->assertEquals(1.9, $cart->getDiscount());
    }

    public function testCanApplyBuyTwoGetOne()
    {
        $product = new Product('Beans');
        $product->setPrice(.65);
        $cart = new Cart();
        $promo = new BuyTwoGetOne();
        $cart->add($product, 2);

        $cart->applyPromo($promo);
        $this->assertEquals(3, $cart->getItemsCount());
        $this->assertEquals(1.3, $cart->getSubtotal());
    }

    public function testCanApplyMoreBuyTwoGetOne()
    {
        $beans = new Product('Beans');
        $coffee = new Product('Coffee');
        $sugar = new Product('Sugar');

        $coffee->setPrice(4);
        $beans->setPrice(.65);
        $sugar->setPrice(.85);

        $cart = new Cart();

        $promo = new BuyTwoGetOne();

        $cart->add($coffee, 6);
        $cart->add($beans, 3);
        $cart->add($sugar, 7);

        $cart->applyPromo($promo);
        $this->assertEquals(23, $cart->getItemsCount());
        $this->assertEquals(31.9, $cart->getSubtotal());
        $this->assertEquals(15.2, $cart->getDiscount());
    }
}