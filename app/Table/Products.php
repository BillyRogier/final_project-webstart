<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class Products extends Table
{
    protected $table = "products";
    #[Properties(type: 'int', length: 11)]
    private $id;
    #[Properties(type: 'string', length: 255)]
    private $name;
    #[Properties(type: 'string', length: 5000)]
    private $description;
    #[Properties(type: 'float', length: 11)]
    private $price;
    #[Properties(type: 'int', length: 11)]
    private $category_id = null;
    #[Properties(type: 'int', length: 4)]
    private $visibility = 1;

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
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of category_id
     */
    public function getCategory_id()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * Get the value of visibility
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set the value of visibility
     *
     * @return  self
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function flush()
    {
        if (isset($this->id)) {
            parent::update(['name', 'description', 'price', 'products.category_id', 'visibility'], "id", [$this->name, $this->description, $this->price, $this->category_id, $this->visibility, $this->id]);
        } else {
            parent::insert(['name', 'description', 'price', 'products.category_id', 'visibility'], [$this->name, $this->description, $this->price, $this->category_id, $this->visibility]);
        }
    }
}
