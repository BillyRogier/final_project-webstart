<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class Categorys extends Table
{
    protected $table = "categorys";
    #[Properties(type: 'int', length: 11)]
    private $category_id = null;
    #[Properties(type: 'string', length: 255)]
    private $category_name = null;
    #[Properties(type: 'string', length: 255)]
    private $category_img = null;
    #[Properties(type: 'string', length: 255)]
    private $alt = null;

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
     * Get the value of category_name
     */
    public function getCategory_name()
    {
        return $this->category_name;
    }

    /**
     * Set the value of category_name
     *
     * @return  self
     */
    public function setCategory_name($category_name)
    {
        $this->category_name = $category_name;

        return $this;
    }

    /**
     * Get the value of category_img
     */
    public function getCategory_img()
    {
        return $this->category_img;
    }

    /**
     * Set the value of category_img
     *
     * @return  self
     */
    public function setCategory_img($category_img)
    {
        $this->category_img = $category_img;

        return $this;
    }

    /**
     * Get the value of alt
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set the value of alt
     *
     * @return  self
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    public function flush()
    {
        if (isset($this->category_id)) {
            parent::update(['category_name', 'category_img', 'alt'], "category_id", [$this->category_name, $this->category_img, $this->alt, $this->category_id]);
        } else {
            parent::insert(['category_name', 'category_img', 'alt'], [$this->category_name, $this->category_img, $this->alt]);
        }
    }
}
