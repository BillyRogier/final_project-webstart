<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class Category extends Table
{
    protected $table = "category";
    #[Properties(type: 'int', length: 11)]
    private int $category_id;
    #[Properties(type: 'string', length: 255)]
    private string $category_name;

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

    public function flush()
    {
        if (isset($this->category_id)) {
            parent::update(['category_name'], [$this->category_name, $this->category_id]);
        } else {
            parent::insert(['category_name'], [$this->category_name]);
        }
    }
}
