<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class Orders extends Table
{
    protected $table = "orders";
    #[Properties(type: 'int', length: 11)]
    private $order_id;
    #[Properties(type: 'int', length: 11)]
    private  $user_id;
    #[Properties(type: 'int', length: 11)]
    private int $product_id;
    #[Properties(type: 'int', length: 11)]
    private $quantity = 1;
    #[Properties(type: 'string')]
    private $order_date;
    #[Properties(type: 'string', length: 255)]
    private $order_num;

    /**
     * Get the value of suer_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of suer_id
     *
     * @return  self
     */
    public function setUser_id($suer_id)
    {
        $this->user_id = $suer_id;

        return $this;
    }

    /**
     * Get the value of product_id
     */
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of order_date
     */
    public function getOrder_date()
    {
        return $this->order_date;
    }

    /**
     * Set the value of order_date
     *
     * @return  self
     */
    public function setOrder_date($order_date)
    {
        $this->order_date = $order_date;

        return $this;
    }


    public function flush()
    {
        if (isset($this->order_id)) {
            parent::update(['user_id', 'product_id', 'quantity', 'order_date', 'order_num'], "order_id", [$this->user_id, $this->product_id, $this->quantity, $this->order_date, $this->order_num, $this->order_id]);
        } else {
            parent::insert(['user_id', 'product_id',  'quantity', 'order_date', 'order_num'], [$this->user_id, $this->product_id, $this->quantity, $this->order_date, $this->order_num]);
        }
    }

    /**
     * Get the value of order_id
     */
    public function getOrder_id()
    {
        return $this->order_id;
    }

    /**
     * Set the value of order_id
     *
     * @return  self
     */
    public function setOrder_id($order_id)
    {
        $this->order_id = $order_id;

        return $this;
    }

    /**
     * Get the value of order_num
     */
    public function getOrder_num()
    {
        return $this->order_num;
    }

    /**
     * Set the value of order_num
     *
     * @return  self
     */
    public function setOrder_num($order_num)
    {
        $this->order_num = $order_num;

        return $this;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }
}
