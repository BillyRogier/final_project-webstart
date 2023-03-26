<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class Orders extends Table
{
    protected $table = "orders";
    #[Properties(type: 'int', length: 11)]
    private int $id;
    #[Properties(type: 'int', length: 11)]
    private int $user_id;
    #[Properties(type: 'int', length: 11)]
    private int $product_id;
    #[Properties(type: 'string')]
    private $order_date;
    #[Properties(type: 'int', length: 20)]
    private int $package_num;

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

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of package_num
     */
    public function getPackage_num()
    {
        return $this->package_num;
    }

    /**
     * Set the value of package_num
     *
     * @return  self
     */
    public function setPackage_num($package_num)
    {
        $this->package_num = $package_num;

        return $this;
    }

    public function flush()
    {
        if (isset($this->id)) {
            parent::update(['user_id', 'product_id', 'order_date', 'package_num'], [$this->user_id, $this->product_id, $this->order_date, $this->package_num, $this->id]);
        } else {
            parent::insert(['user_id', 'product_id', 'package_num'], [$this->user_id, $this->product_id, $this->package_num]);
        }
    }
}
