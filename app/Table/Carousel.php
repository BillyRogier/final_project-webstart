<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class Carousel extends Table
{
    protected $table = "carousel";
    #[Properties(type: 'int', length: 11)]
    private $carousel_id;
    #[Properties(type: 'string', length: 255)]
    private $img;
    #[Properties(type: 'int', length: 2)]
    private $type;
    #[Properties(type: 'int', length: 11)]
    private $product_id;

    /**
     * Get the value of img
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set the value of img
     *
     * @return  self
     */
    public function setImg($img)
    {
        $this->img = $img;

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


    public function flush()
    {
        if (isset($this->carousel_id)) {
            parent::update(['img', 'product_id', 'type'], [$this->img, $this->product_id, $this->type, $this->carousel_id]);
        } else {
            parent::insert(['img', 'product_id', 'type'], [$this->img, $this->product_id, $this->type]);
        }
    }

    /**
     * Get the value of carousel_id
     */
    public function getCarousel_id()
    {
        return $this->carousel_id;
    }

    /**
     * Set the value of carousel_id
     *
     * @return  self
     */
    public function setCarousel_id($carousel_id)
    {
        $this->carousel_id = $carousel_id;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
