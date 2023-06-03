<?php

namespace Core\Cart;

class Cart
{
    private $cart;

    public function __construct()
    {
        if (isset($_SESSION['cart'])) {
            $this->cart = $_SESSION['cart'];
        } else {
            $this->cart = array();
        }
    }

    public function addToCart($id, $quantity)
    {
        if (isset($this->cart[$id])) {
            $this->cart[$id] += $quantity;
        } else {
            $this->cart[$id] = $quantity;
        }

        $_SESSION['cart'] = $this->cart;
    }

    public function removeFromCart($id)
    {
        if (isset($this->cart[$id])) {
            unset($this->cart[$id]);
            $_SESSION['cart'] = $this->cart;
        }
    }

    public function setQuantity($id, $quantity)
    {
        if (isset($this->cart[$id])) {
            $this->cart[$id] = $quantity;
            $_SESSION['cart'] = $this->cart;
        }
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function cleanCart()
    {
        $this->cart = [];
        $_SESSION['cart'] = $this->cart;
    }

    public function countItems()
    {
        $totalCount = 0;
        foreach ($this->cart as $quantity) {
            $totalCount += $quantity;
        }
        return $totalCount;
    }
}
