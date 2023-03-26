<?php

namespace App\Cart;

class Cart
{
    private $cart;

    public function __construct()
    {
        $this->cart = $this->getCart();
    }

    public function getCart()
    {
        if (isset($_COOKIE['cart'])) {
            return unserialize($_COOKIE['cart']);
        } else {
            return [];
        }
    }

    public function setCart()
    {
        setcookie("cart", serialize($this->cart), time() + 3600, "/");
    }

    /**
     * add item in cart
     */
    public function addToCart($product, $quantity)
    {
        if (!isset($this->cart[$product])) {
            $this->cart[$product] = $quantity;
        } else {
            $this->cart[$product] += $quantity;
        }
        $this->setCart();
    }

    /**
     * remove item in cart
     */
    public function removeFromCart($product)
    {
        unset($this->cart[$product]);
        $this->setCart();
    }

    /**
     * count number of item in cart
     */
    public function getNumItems()
    {
    }
}
